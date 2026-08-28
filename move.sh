#!/usr/bin/env bash
set -euo pipefail

# ============================================================
# fix-namespaces.sh
# Memperbaiki isi 'namespace' dan 'use' di file-file yang SUDAH
# terlanjur dipindah fisiknya ke app/Filament/Resources, tapi
# isi namespace-nya belum ikut berubah (karena sed sebelumnya
# gagal menangani backslash).
#
# Jalankan dari root project:
#   bash fix-namespaces.sh
# ============================================================

python3 - <<'PYEOF'
import os

APP_DIR = "app"

REPLACEMENTS = [
    ("App\\Filament\\Parapoint\\Resources", "App\\Filament\\Resources"),
    ("App\\Filament\\Reading\\Resources", "App\\Filament\\Resources"),
]

changed_files = []

for root, dirs, files in os.walk(APP_DIR):
    for fname in files:
        if not fname.endswith(".php"):
            continue
        fpath = os.path.join(root, fname)
        with open(fpath, "r", encoding="utf-8") as f:
            content = f.read()

        original = content
        for old, new in REPLACEMENTS:
            content = content.replace(old, new)

        if content != original:
            with open(fpath, "w", encoding="utf-8") as f:
                f.write(content)
            changed_files.append(fpath)

print(f"Total file diperbaiki: {len(changed_files)}")
for f in changed_files:
    print(" -", f)
PYEOF

echo ""
echo "== Selesai. Jalankan sekarang: =="
echo "  composer dump-autoload"
echo "  php artisan optimize:clear"