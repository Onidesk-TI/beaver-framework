#!/usr/bin/env bash
#
# Beaver Framework — SDK setup
# Cria a árvore de pastas do SDK com permissões corretas.
#
# Uso:
#   ./scripts/sdk-setup.sh
#   ./scripts/sdk-setup.sh --user franco:franco
#
set -euo pipefail

OWNER="${USER}:${USER}"
SDK_DIR="sdk"

while [[ $# -gt 0 ]]; do
    case "$1" in
        --user) OWNER="$2"; shift 2 ;;
        --dir)  SDK_DIR="$2"; shift 2 ;;
        -h|--help) grep '^#' "$0" | sed 's/^# \{0,1\}//'; exit 0 ;;
        *) echo "Opção desconhecida: $1" >&2; exit 1 ;;
    esac
done

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

echo "==> Beaver SDK setup"
echo "    root:  $ROOT"
echo "    sdk:   $SDK_DIR"
echo "    owner: $OWNER"
echo

mkdir -p "$SDK_DIR"/src/Testing
mkdir -p "$SDK_DIR"/schema
mkdir -p "$SDK_DIR"/tests/Unit

chown -R "$OWNER" "$SDK_DIR" 2>/dev/null || \
    echo "    (aviso: chown falhou — provavelmente não precisas de sudo)"

chmod -R 775 "$SDK_DIR"
find "$SDK_DIR" -type d -exec chmod g+s {} \;

echo "==> Estrutura criada:"
find "$SDK_DIR" -type d | sort | sed 's|^|    |'

echo
echo "✔ Pastas do SDK prontas."
