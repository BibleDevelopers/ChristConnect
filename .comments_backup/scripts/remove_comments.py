#!/usr/bin/env python3
import re
import sys
from pathlib import Path
import shutil

ROOT = Path('.').resolve()
EXCLUDE_DIRS = {'.git','vendor','node_modules','storage','public','bootstrap/cache','.comments_backup'}
TEXT_EXTS = {'.php','.js','.ts','.jsx','.tsx','.css','.scss','.html','.htm','.blade.php','.vue','.json','.md','.txt','.env','.yml','.yaml','.xml','.ini','.cfg','.conf','.jsonld','.lock'}

# patterns: list of (name, regex, flags)
PATTERNS = [
    # Blade comments {{-- --}}
    (re.compile(r"\{\{\-\-([\s\S]*?)\-\-\}\}", re.MULTILINE), ''),
    # HTML/XML comments
    (re.compile(r"<!--([\s\S]*?)-->", re.MULTILINE), ''),
    # PHP/JS/C-style block comments /* */
    (re.compile(r"/\*([\s\S]*?)\*/", re.MULTILINE), ''),
    # C++/JS style single-line //
    (re.compile(r"//.*?$", re.MULTILINE), ''),
    # Shell/env comments starting with # (remove whole line)
    (re.compile(r"(?m)^[ \t]*#.*?$\n?", re.MULTILINE), ''),
]


def is_binary(path: Path) -> bool:
    try:
        data = path.read_bytes()
    except Exception:
        return True
    return b'\0' in data


def should_process(path: Path) -> bool:
    if any(part in EXCLUDE_DIRS for part in path.parts):
        return False
    if path.is_dir():
        return False
    if path.suffix.lower() in TEXT_EXTS or any(str(path).endswith(ext) for ext in ['.blade.php']):
        return True
    # include files without extension but small text files
    try:
        if path.stat().st_size > 1024*1024*5:
            return False
    except Exception:
        return False
    # try to read sample
    try:
        s = path.read_text(encoding='utf-8', errors='ignore')
        # heuristic: contains typical ascii
        if '\n' in s and re.search(r'[a-zA-Z]', s):
            return True
    except Exception:
        return False
    return False


def process_file(path: Path, backup_root: Path):
    try:
        if is_binary(path):
            return False
        txt = path.read_text(encoding='utf-8', errors='ignore')
    except Exception as e:
        print(f"Skipping (read error): {path} -> {e}")
        return False

    original = txt
    for pat, repl in PATTERNS:
        txt = pat.sub(repl, txt)

    if txt != original:
        # backup
        dest = backup_root / path.relative_to(ROOT)
        dest.parent.mkdir(parents=True, exist_ok=True)
        shutil.copy2(path, dest)
        # write file
        path.write_text(txt, encoding='utf-8')
        print(f"Stripped comments: {path}")
        return True
    return False


def main():
    backup_root = ROOT / '.comments_backup'
    backup_root.mkdir(exist_ok=True)
    changed = []
    for path in sorted(ROOT.rglob('*')):
        if should_process(path):
            try:
                ok = process_file(path, backup_root)
                if ok:
                    changed.append(path)
            except Exception as e:
                print(f"Error processing {path}: {e}")
    print('\nSummary:')
    print(f'Total files modified: {len(changed)}')
    for p in changed[:200]:
        print(' -', p)

if __name__ == '__main__':
    main()
