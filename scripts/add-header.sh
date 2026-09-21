#!/usr/bin/env bash
set -euo pipefail

TARGET_DIR="${1:-.}"
[ -d "$TARGET_DIR" ] || { echo "❌ Diretório não existe: $TARGET_DIR"; exit 1; }
cd "$TARGET_DIR"

HEADER='/**
 * Beaver Framework — Modern PHP framework with a plugin ecosystem.
 *
 * @package    Beaver Framework
 * @version    0.1.0
 * @author     Franco <onidesk@outlook.com>
 * @copyright  2026 Onidesk
 * @license    GPL-3.0-or-later <https://www.gnu.org/licenses/gpl-3.0.txt>
 * @link       https://github.com/Onidesk-TI/beaver-framework
 */'

MARKER="@package    Beaver Framework"

count=0; skipped=0; errors=0; ignored=0

echo "═══════════════════════════════════════════════"
echo "  add-header.sh → $(pwd)"
echo "═══════════════════════════════════════════════"

while IFS= read -r file; do
    grep -q "$MARKER" "$file" 2>/dev/null && { ((skipped++)) || true; continue; }
    head -1 "$file" | grep -q "^<?php" || { ((ignored++)) || true; continue; }

    { echo "<?php"; echo ""; echo "$HEADER"; tail -n +2 "$file"; } > "$file.tmp"

    if php -l "$file.tmp" > /dev/null 2>&1; then
        mv "$file.tmp" "$file"
        ((count++)) || true
    else
        rm -f "$file.tmp"
        echo "❌ $file"
        ((errors++)) || true
    fi
done < <(find . -type f -name "*.php" \
    -not -path "./vendor/*" \
    -not -path "./storage/*" \
    -not -path "./.git/*" \
    -not -path "./node_modules/*" \
    -not -path "./tests/Fixtures/*" \
    -not -path "./beaver-docs/partials/*" | sort)

echo
echo "  ✅ Aplicados:        $count"
echo "  ⏭  Já tinham header: $skipped"
echo "  ⏭  Ignorados:        $ignored"
echo "  ❌ Erros:            $errors"
echo "═══════════════════════════════════════════════"

[ "$errors" -gt 0 ] && exit 1
exit 0
