#!/usr/bin/env bash
#
# Beaver Framework — SDK install (setup + files + verify)
#
# Uso:
#   ./scripts/sdk-install.sh
#   ./scripts/sdk-install.sh --force
#
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

FORCE_FLAG=""
[[ "${1:-}" == "--force" ]] && FORCE_FLAG="--force"

echo "╔══════════════════════════════════════════╗"
echo "║   Beaver SDK — instalação completa       ║"
echo "╚══════════════════════════════════════════╝"
echo

./scripts/sdk-setup.sh
echo
./scripts/sdk-files.sh $FORCE_FLAG

echo
echo "==> Verificar sintaxe PHP..."
err=0
while IFS= read -r f; do
    if out=$(php -l "$f" 2>&1); then
        echo "    ✓ $f"
    else
        echo "    ✗ $f"
        echo "      $out"
        err=1
    fi
done < <(find sdk -name "*.php" | sort)

echo
echo "==> Verificar JSON..."
for f in sdk/composer.json sdk/schema/plugin.schema.json; do
    if php -r "json_decode(file_get_contents('$f'), true, 512, JSON_THROW_ON_ERROR);" 2>/dev/null; then
        echo "    ✓ $f"
    else
        echo "    ✗ $f (JSON inválido)"
        err=1
    fi
done

echo
if [[ $err -eq 0 ]]; then
    echo "✔ SDK instalado e validado."
else
    echo "✗ Há erros — vê acima." >&2
    exit 1
fi
