#!/usr/bin/env bash
#
# add-header.sh — Aplica o header padrão do Beaver Framework
#                   a todos os ficheiros PHP do projeto.
#
# Uso:
#   ./add-header.sh            (aplica na pasta atual)
#   ./add-header.sh /caminho   (aplica noutro diretório)
#

set -euo pipefail

TARGET_DIR="${1:-.}"

if [ ! -d "$TARGET_DIR" ]; then
    echo "❌ Diretório não existe: $TARGET_DIR"
    exit 1
fi

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

count=0
skipped=0
errors=0
ignored=0

echo "═══════════════════════════════════════════════"
echo "  Beaver Framework — add-header.sh"
echo "  Diretório: $(pwd)"
echo "═══════════════════════════════════════════════"
echo

while IFS= read -r file; do
    # já tem header?
    if grep -q "$MARKER" "$file" 2>/dev/null; then
        ((skipped++)) || true
        continue
    fi

    # primeiro line tem de ser <?php
    if ! head -1 "$file" | grep -q "^<?php"; then
        ((ignored++)) || true
        continue
    fi

    # construir novo conteúdo
    {
        echo "<?php"
        echo ""
        echo "$HEADER"
        tail -n +2 "$file"
    } > "$file.tmp"

    # validar sintaxe antes de substituir
    if php -l "$file.tmp" > /dev/null 2>&1; then
        mv "$file.tmp" "$file"
        ((count++)) || true
    else
        rm -f "$file.tmp"
        echo "❌ erro de sintaxe, mantido original: $file"
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
echo "═══════════════════════════════════════════════"
echo "  ✅ Aplicados:        $count"
echo "  ⏭  Já tinham header: $skipped"
echo "  ⏭  Ignorados:        $ignored (não começam com <?php)"
echo "  ❌ Erros:            $errors"
echo "═══════════════════════════════════════════════"

[ "$errors" -gt 0 ] && exit 1
exit 0
