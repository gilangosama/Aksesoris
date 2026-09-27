#!/usr/bin/env python3
import re
from pathlib import Path
import json

root = Path('resources/views')

def clean_text(t):
    t = t.strip()
    if not t:
        return None
    # skip if looks like blade or html element only
    if '{{' in t or '}}' in t or t.startswith('@'):
        return None
    # skip script/style parts and numeric-only or non-words
    if re.match(r'^[\s\d\W]+$', t):
        return None
    # collapse spaces
    t = re.sub(r'\s+', ' ', t)
    return t


def slugify(text):
    text = text.lower()
    text = re.sub(r"[^a-z0-9]+", '_', text)
    text = re.sub(r'_+', '_', text)
    text = text.strip('_')[:60]
    return text or 'text'


def key_for(file_path, text):
    # group by folder and filename
    rel = file_path.relative_to(root)
    parts = rel.with_suffix('').parts
    parts = [p.replace('.blade', '').replace('-', '_') for p in parts]
    slug = slugify(text)
    return '.'.join(['ui'] + list(parts) + [slug])


def parse_file(path):
    raw = path.read_text(encoding='utf-8')
    # remove Blade expressions to avoid false positives
    safe = re.sub(r'\{\{.*?\}\}', '', raw)
    safe = re.sub(r'\{!!.*?!!\}', '', safe)
    # remove tags content > < pattern
    texts = []

    # collect plain text segments between > and <
    for m in re.finditer(r'>([^<>]+)<', safe):
        chunk = m.group(1)
        c = clean_text(chunk)
        if c:
            texts.append(c)
    # also capture alt/title attributes with plain text
    for attr in re.finditer(r'(?:alt|title|placeholder|aria-label)\s*=\s*"([^"]+)"', raw):
        c = clean_text(attr.group(1))
        if c:
            texts.append(c)

    return texts


def main():
    mapping = {}
    for path in root.rglob('*.blade.php'):
        if 'vendor' in path.parts:
            continue
        texts = parse_file(path)
        for t in texts:
            if len(t) <= 1:
                continue
            key = key_for(path, t)
            # avoid too long keys, ensure uniqueness
            if key in mapping and mapping[key] != t:
                # duplicate key already with other value; append suffix
                key_base = key
                i = 2
                while f'{key_base}_{i}' in mapping:
                    i += 1
                key = f'{key_base}_{i}'
            mapping[key] = t

    # Now replace in views
    for path in root.rglob('*.blade.php'):
        if 'vendor' in path.parts:
            continue
        content = path.read_text(encoding='utf-8')
        rel_str = str(path.relative_to(root).with_suffix('')).replace('\\', '.').replace('/', '.').replace('.blade', '').replace('-', '_')
        prefix = 'ui.' + rel_str + '.'
        for key, text in mapping.items():
            if key.startswith(prefix):
                content = content.replace(text, "{{ __('" + key + "') }}")
        path.write_text(content, encoding='utf-8')

    ui_en = Path('resources/lang/en/ui.php')
    ui_id = Path('resources/lang/id/ui.php')

    def write_file(path, locale_map, target='en'):
        lines = ["<?php", "", "return ["]
        for k, v in sorted(locale_map.items()):
            if target == 'en':
                val = v.replace("'", "\\'")
            else:
                val = ''
            lines.append(f"    '{k}' => '{val}',")
        lines.append('];')
        content = '\n'.join(lines) + '\n'
        path.parent.mkdir(parents=True, exist_ok=True)
        path.write_text(content, encoding='utf-8')

    write_file(ui_en, mapping, 'en')
    write_file(ui_id, mapping, 'id')

    # report some stats
    print(f'Found {len(mapping)} i18n strings, written ui.php for en and id')


if __name__ == '__main__':
    main()
