#!/usr/bin/env bash
#
# create-plugin.sh
# Cria um plugin Beaver em /var/www/onidesk/<nome>/ e liga-o ao framework.
#
# Uso:
#   sudo ./create-plugin.sh <nome-do-plugin>
#
# Exemplo:
#   sudo ./create-plugin.sh beaver-skeleton

set -euo pipefail

# ---- Cores ---------------------------------------------------
G="\033[1;32m"; Y="\033[1;33m"; R="\033[1;31m"; N="\033[0m"
info() { echo -e "${G}✔${N} $*"; }
warn() { echo -e "${Y}➜${N} $*"; }
fail() { echo -e "${R}✖${N} $*" >&2; exit 1; }

# ---- Config --------------------------------------------------
OWNER="franco:franco"
BASE="/var/www/onidesk"
FRAMEWORK="$BASE/beaver-framework"

# ---- Verificações --------------------------------------------
[[ $EUID -eq 0 ]] || fail "Corre com sudo."
PLUGIN_NAME="${1:-}"
[[ -n "$PLUGIN_NAME" ]] || fail "Uso: $0 <nome-do-plugin>"

[[ "$PLUGIN_NAME" =~ ^[a-zA-Z][a-zA-Z0-9_-]*$ ]] \
  || fail "Nome inválido: '$PLUGIN_NAME'."

USER_NAME="${OWNER%%:*}"
GROUP_NAME="${OWNER##*:}"
id "$USER_NAME" &>/dev/null          || fail "Utilizador '$USER_NAME' não existe."
getent group "$GROUP_NAME" &>/dev/null || fail "Grupo '$GROUP_NAME' não existe."

PLUGIN_DIR="$BASE/$PLUGIN_NAME"
PLUGINS_LINK="$FRAMEWORK/plugins/$PLUGIN_NAME"
PUBLIC_LINK="$FRAMEWORK/public/plugins/$PLUGIN_NAME"

[[ -e "$PLUGIN_DIR"   ]] && fail "'$PLUGIN_DIR' já existe."
[[ -e "$PLUGINS_LINK" ]] && fail "'$PLUGINS_LINK' já existe."
[[ -e "$PUBLIC_LINK"  ]] && fail "'$PUBLIC_LINK' já existe."

# ==============================================================
#  FASE 1 — criar o plugin em /var/www/onidesk/<nome>/
# ==============================================================
info "FASE 1 — criar $PLUGIN_DIR"

mkdir -p "$PLUGIN_DIR"/{src/Config,src/Http/Controllers,src/Console/Commands,src/Support}
mkdir -p "$PLUGIN_DIR"/{resources/views,resources/ui/css,resources/ui/js}
mkdir -p "$PLUGIN_DIR"/{routes,database/migrations,tests,config}

cat > "$PLUGIN_DIR/composer.json" <<'JSON'
{
    "name": "onidesk-ti/__NAME__",
    "description": "Plugin Beaver: __NAME__",
    "type": "library",
    "license": "MIT",
    "require": {
        "php": "^8.1",
        "onidesk-ti/beaver-framework": "^1.0"
    },
    "autoload": {
        "psr-4": {
            "Onidesk\\__STUDLY__\\": "src/"
        }
    },
    "extra": {
        "beaver": {
            "provider": "Onidesk\\__STUDLY__\\PluginServiceProvider"
        }
    }
}
JSON

cat > "$PLUGIN_DIR/README.md" <<EOF
# $PLUGIN_NAME

Plugin Beaver Framework.

## Instalação

\`\`\`bash
cd /var/www/onidesk/beaver-framework
composer require onidesk-ti/$PLUGIN_NAME
\`\`\`

## Estrutura

- \`src/\` — código PHP
- \`resources/\` — views e assets
- \`routes/\` — rotas do plugin
- \`database/migrations/\` — migrations
- \`tests/\` — testes
EOF

cat > "$PLUGIN_DIR/src/Plugin.php" <<'PHP'
<?php
declare(strict_types=1);

namespace Onidesk\__STUDLY__;

final class Plugin
{
    public const NAME    = '__NAME__';
    public const SLUG    = '__NAME__';
    public const VERSION = '1.0.0';

    private static ?self $instance = null;
    private array $config;

    private function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public static function instance(): self
    {
        return self::$instance ??= new self();
    }

    public static function boot(array $config = []): self
    {
        self::$instance = new self($config);
        return self::$instance;
    }

    public function config(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) return $this->config;
        $value = $this->config;
        foreach (explode('.', $key) as $seg) {
            if (!is_array($value) || !array_key_exists($seg, $value)) return $default;
            $value = $value[$seg];
        }
        return $value;
    }
}
PHP

cat > "$PLUGIN_DIR/src/PluginServiceProvider.php" <<'PHP'
<?php
declare(strict_types=1);

namespace Onidesk\__STUDLY__;

final class PluginServiceProvider
{
    public function register(): void
    {
        // registar config, rotas, views, etc.
    }

    public function boot(): void
    {
        Plugin::boot();
    }
}
PHP

cat > "$PLUGIN_DIR/resources/ui/css/$PLUGIN_NAME.css" <<'CSS'
:root{
  --amber-1:#FFD79A;
  --amber-2:#FF9A3C;
  --amber-3:#FF6B35;
  --brown:#8B5E3C;
  --brown-dark:#6B4423;
}
CSS

cat > "$PLUGIN_DIR/resources/ui/js/$PLUGIN_NAME.js" <<'JS'
(() => {
  'use strict';
  console.log('[__NAME__] carregado');
})();
JS

cat > "$PLUGIN_DIR/.gitignore" <<'GIT'
/vendor/
composer.lock
.phpunit.result.cache
.idea/
.vscode/
*.log
.DS_Store
GIT

# Substituições nos templates
find "$PLUGIN_DIR" -type f -exec sed -i "s/__NAME__/$PLUGIN_NAME/g" {} \;
STUDLY=$(echo "$PLUGIN_NAME" | awk -F- '{for(i=1;i<=NF;i++) $i=toupper(substr($i,1,1)) substr($i,2); print}' OFS=)
find "$PLUGIN_DIR" -type f -exec sed -i "s/__STUDLY__/$STUDLY/g" {} \;

# Permissões e dono
find "$PLUGIN_DIR" -type d -exec chmod 755 {} \;
find "$PLUGIN_DIR" -type f -exec chmod 644 {} \;
chown -R "$OWNER" "$PLUGIN_DIR"
info "Plugin criado em $PLUGIN_DIR"

# ==============================================================
#  FASE 2 — ligar ao framework
# ==============================================================
info "FASE 2 — criar symlinks"

mkdir -p "$FRAMEWORK/plugins" "$FRAMEWORK/public/plugins"

ln -s "$PLUGIN_DIR"              "$PLUGINS_LINK"
ln -s "$PLUGIN_DIR/resources/ui" "$PUBLIC_LINK"

chown -h "$OWNER" "$PLUGINS_LINK" "$PUBLIC_LINK"

info "Symlink:  $PLUGINS_LINK  ->  $PLUGIN_DIR"
info "Symlink:  $PUBLIC_LINK   ->  $PLUGIN_DIR/resources/ui"

# ---- Resumo --------------------------------------------------
echo
echo -e "${G}Plugin '$PLUGIN_NAME' pronto.${N}"
echo
echo "Estrutura:"
find "$PLUGIN_DIR" -maxdepth 3 | sort | sed 's/^/  /'
echo
echo "Ligações:"
ls -la "$FRAMEWORK/plugins/"        | grep "$PLUGIN_NAME" | sed 's/^/  /'
ls -la "$FRAMEWORK/public/plugins/" | grep "$PLUGIN_NAME" | sed 's/^/  /'