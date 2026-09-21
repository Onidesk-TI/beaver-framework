#!/usr/bin/env bash
#
# add-gitkeep.sh — Adiciona .gitkeep a todas as pastas vazias
#                  (excluindo vendor, storage runtime, etc.)
#
# Uso:
#   ./add-gitkeep.sh [diretório]
#

set -euo pipefail

TARGET_DIR="${1:-.}"
[ -d "$TARGET_DIR" ] || { echo "❌ Diretório não existe: $TARGET_DIR"; exit 1; }
cd "$TARGET_DIR"

count=0
skipped=0

echo "═══════════════════════════════════════════════"
echo "  add-gitkeep.sh"
echo "  Diretório: $(pwd)"
echo "═══════════════════════════════════════════════"
echo

# percorre todas as pastas
while IFS= read -r dir; do
    # ignorar pastas específicas
    case "$dir" in
        ./vendor/*|./vendor|./.git/*|./.git) continue ;;
        ./node_modules/*|./node_modules) continue ;;
        ./storage/cache/*|./storage/logs/*|./storage/sessions/*|./storage/framework/*|./storage/frankei-cache/*) continue ;;
    esac

    # ignora se já tem .gitkeep
    [ -f "$dir/.gitkeep" ] && { ((skipped++)) || true; continue; }

    # verifica se está vazia (só ficheiros invisíveis não contam)
    contents=$(ls -A "$dir" 2>/dev/null | wc -l)
    if [ "$contents" -eq 0 ]; then
        touch "$dir/.gitkeep"
        echo "➕ $dir/.gitkeep"
        ((count++)) || true
    fi
done < <(find . -type d | sort)

echo
echo "═══════════════════════════════════════════════"
echo "  ✅ Criados:        $count"
echo "  ⏭  Já tinham:      $skipped"
echo "═══════════════════════════════════════════════"
