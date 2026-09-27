from pathlib import Path
import re

root = Path('resources/views')
files = list(root.rglob('*.blade.php'))
modified = 0
for path in files:
    text = path.read_text(encoding='utf-8', errors='replace')
    new_text = text.replace('\x03', '')
    if new_text != text:
        path.write_text(new_text, encoding='utf-8')
        modified += 1
print(f'cleaned {modified} files')
