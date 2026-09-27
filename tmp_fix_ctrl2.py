from pathlib import Path
import re
root = Path('resources/views')
files = list(root.rglob('*.blade.php'))
cleaned = 0
info = []
for path in files:
    text = path.read_text(encoding='utf-8', errors='surrogateescape')
    c = text.count('\x03')
    if c>0:
        info.append(f'{path}: {c}')
        new_text = text.replace('\x03', '')
        path.write_text(new_text, encoding='utf-8')
        cleaned += 1
with open('tmp_fix_ctrl2.log', 'w', encoding='utf-8') as f:
    f.write(f'cleaned={cleaned}\n')
    f.write('\n'.join(info))
