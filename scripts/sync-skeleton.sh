#!/usr/bin/env bash
#
# sync-skeleton.sh
#
# Sincroniza o beaver-skeleton (source) para a cópia dentro do framework.
#
# Uso:
#   ./scripts/sync-skeleton.sh
#   ./scripts/sync-skeleton.sh --dry-run
#   ./scripts/sync-skeleton.sh --diff
#
set -euo pipefail

SRC="/var/www/onidesk/beaver-skeleton"
DST="$(cd "$(dirname "$0")/.." && pwd)/plugins/beaver-skeleton"

DRY_RUN=0
SHOW_DIFF=0

while [[ $# -gt 0 ]]; do
    case "$1" in
        --dry-run) DRY_RUN=1; shift ;;
        --diff)    SHOW_DIFF=1; shift ;;
        -h|--help)
            grep '^#' "$0" | sed 's/^# \{0,1\}//'
            exit 0
            ;;
        *) echo "Opção desconhecida: $1" >&2; exit 1 ;;
    esac
done

echo "==> Beaver Skeleton — sync"
echo "    source:  $SRC"
echo "    destino: $DST"
echo "    modo:    $([[ $DRY_RUN -eq 1 ]] && echo 'dry-run' || echo 'aplicar')"
echo

[[ -d "$SRC" ]] || { echo "✗ Source não existe: $SRC" >&2; exit 1; }
[[ -d "$DST" ]] || { echo "✗ Destino não existe: $DST" >&2; exit 1; }

# Ficheiros/pastas que NÃO devem ser copiados
EXCLUDE=(
    ".git"
    ".gitignore"
    ".phpunit.cache"
    "vendor"
    "composer.lock"
    "reports"
    "test-results.txt"
    ".env"
    ".env.local"
)

# Constrói argumentos do rsync
RSYNC_ARGS=(-a --delete)
for e in "${EXCLUDE[@]}"; do
    RSYNC_ARGS+=(--exclude="$e")
done

if [[ $DRY_RUN -eq 1 ]]; then
    RSYNC_ARGS+=(--dry-run -v)
fi

if [[ $SHOW_DIFF -eq 1 ]]; then
    echo "==> Diff:"
    diff -r \
        --exclude=.git \
        --exclude=.gitignore \
        --exclude=.phpunit.cache \
        --exclude=vendor \
        --exclude=composer.lock \
        --exclude=reports \
        --exclude=test-results.txt \
        "$SRC" "$DST" \
        | head -60 \
        || true
    echo
fi

if command -v rsync >/dev/null 2>&1; then
    echo "==> rsync (preserva permissões, --delete)"
    rsync "${RSYNC_ARGS[@]}" "$SRC/" "$DST/"
else
    echo "==> rsync não disponível — a usar cp -r"
    if [[ $DRY_RUN -eq 1 ]]; then
        echo "    (dry-run ignorado sem rsync)"
        exit 0
    fi
    for e in "${EXCLUDE[@]}"; do
        rm -rf "$DST/$e"
    done
    cp -r "$SRC"/* "$DST/" 2>/dev/null || true
fi

if [[ $DRY_RUN -eq 0 ]]; then
    # Remover .git residual (caso exista na cópia)
    rm -rf "$DST/.git"

    echo
    echo "==> Estrutura final:"
    find "$DST" -maxdepth 1 -mindepth 1 -type d | sort | sed 's|^|    |'

    echo
    echo "✔ Sync concluído."
    echo
    echo "Próximos passos:"
    echo "  composer dump-autoload"
    echo "  php beaver plugin:validate beaver-skeleton"
    echo "  git add plugins/beaver-skeleton/"
fi
