import re
from pathlib import Path
root = Path('resources')
ui_keys = set()
for p in root.rglob('*.blade.php'):
    text = p.read_text(encoding='utf-8', errors='ignore')
    for m in re.finditer(r"__\(\s*['\"](ui\.[^'\"]+)['\"]", text):
        ui_keys.add(m.group(1))
    for m in re.finditer(r"@lang\(\s*['\"](ui\.[^'\"]+)['\"]", text):
        ui_keys.add(m.group(1))
lang = Path('resources/lang/en/ui.php').read_text(encoding='utf-8', errors='ignore')
lang_keys = set(re.findall(r"['\"](ui\.[^'\"]+)['\"]\s*=>", lang))
missing = sorted(k for k in ui_keys if k not in lang_keys)
print('missing count', len(missing))
for k in missing:
    print(k)
