#!/usr/bin/env bash
#
# Beaver Framework — SDK files
# Gera os ficheiros-base do SDK (composer.json, schema, classes).
#
# Uso:
#   ./scripts/sdk-files.sh
#   ./scripts/sdk-files.sh --force   # sobrescreve ficheiros existentes
#
set -euo pipefail

FORCE=0
while [[ $# -gt 0 ]]; do
    case "$1" in
        --force) FORCE=1; shift ;;
        -h|--help) grep '^#' "$0" | sed 's/^# \{0,1\}//'; exit 0 ;;
        *) echo "Opção desconhecida: $1" >&2; exit 1 ;;
    esac
done

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"
SDK_DIR="sdk"

if [[ ! -d "$SDK_DIR" ]]; then
    echo "✗ Pasta $SDK_DIR não existe. Corre primeiro: ./scripts/sdk-setup.sh" >&2
    exit 1
fi

write_file() {
    local path="$1"
    local mode="${2:-664}"
    if [[ -f "$path" && $FORCE -eq 0 ]]; then
        echo "    ~ $path (já existe; usa --force para sobrescrever)"
        cat > /dev/null
        return
    fi
    cat > "$path"
    chmod "$mode" "$path"
    echo "    + $path"
}

echo "==> A gerar ficheiros do SDK (force=$FORCE)..."

write_file "$SDK_DIR/composer.json" 664 <<'JSON'
{
    "name": "onidesk/beaver-sdk",
    "description": "SDK oficial para desenvolvimento de plugins do Beaver Framework",
    "type": "library",
    "license": "GPL-3.0-or-later",
    "require": {
        "php": ">=8.1"
    },
    "require-dev": {
        "phpunit/phpunit": "^10.0"
    },
    "autoload": {
        "psr-4": {
            "Beaver\\Sdk\\": "src/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Beaver\\Sdk\\Tests\\": "tests/"
        }
    },
    "config": {
        "optimize-autoloader": true,
        "sort-packages": true
    }
}
JSON

write_file "$SDK_DIR/schema/plugin.schema.json" 664 <<'JSON'
{
    "$schema": "https://json-schema.org/draft/2020-12/schema",
    "$id": "https://onidesk.com/schemas/beaver-plugin.json",
    "title": "Beaver Plugin Manifest",
    "type": "object",
    "required": ["name", "slug", "version", "namespace", "main", "beaver_version"],
    "additionalProperties": false,
    "properties": {
        "name":           { "type": "string", "minLength": 2, "maxLength": 60 },
        "slug":           { "type": "string", "pattern": "^[a-z][a-z0-9_]*$" },
        "version":        { "type": "string", "pattern": "^\\d+\\.\\d+\\.\\d+$" },
        "author":         { "type": "string" },
        "description":    { "type": "string", "maxLength": 200 },
        "namespace":      { "type": "string", "pattern": "^[A-Z][A-Za-z0-9_\\\\]+$" },
        "main":           { "type": "string", "pattern": "\\.php$" },
        "beaver_version": { "type": "string" },
        "api_version":    { "type": "string", "default": "1.0.0" },
        "requires": {
            "type": "object",
            "properties": {
                "php":     { "type": "string" },
                "ext":     { "type": "array", "items": { "type": "string" } },
                "plugins": { "type": "array", "items": { "type": "string" } }
            }
        },
        "permissions": {
            "type": "array",
            "items": {
                "type": "string",
                "enum": [
                    "db.read", "db.write",
                    "http.outbound",
                    "fs.read", "fs.write",
                    "hooks.listen", "hooks.emit",
                    "routes.register",
                    "views.register",
                    "migrations.run",
                    "settings.manage"
                ]
            }
        },
        "admin_menu": {
            "type": "object",
            "properties": {
                "label": { "type": "string" },
                "icon":  { "type": "string" },
                "order": { "type": "integer" }
            }
        },
        "routes": { "type": "string" }
    }
}
JSON

write_file "$SDK_DIR/src/SdkVersion.php" 664 <<'PHP'
<?php

declare(strict_types=1);

/**
 * Beaver Framework — Modern PHP framework with a plugin ecosystem.
 *
 * @package    Beaver SDK
 * @version    0.1.0
 * @author     Franco <onidesk@outlook.com>
 * @copyright  2026 Onidesk
 * @license    GPL-3.0-or-later <https://www.gnu.org/licenses/gpl-3.0.txt>
 * @link       https://github.com/Onidesk-TI/beaver-framework
 */

namespace Beaver\Sdk;

final class SdkVersion
{
    public const API_VERSION   = '1.0.0';
    public const MIN_FRAMEWORK = '0.1.0';

    public static function satisfies(string $version, string $constraint): bool
    {
        $constraint = trim($constraint);

        if (preg_match('/^>=\s*(\d+\.\d+\.\d+)$/', $constraint, $m)) {
            return version_compare($version, $m[1], '>=');
        }

        if (preg_match('/^\^(\d+\.\d+\.\d+)$/', $constraint, $m)) {
            [$maj] = explode('.', $m[1]);
            return version_compare($version, $m[1], '>=')
                && version_compare($version, ((int) $maj + 1) . '.0.0', '<');
        }

        return false;
    }
}
PHP

write_file "$SDK_DIR/src/Manifest.php" 664 <<'PHP'
<?php

declare(strict_types=1);

/**
 * Beaver Framework — Modern PHP framework with a plugin ecosystem.
 *
 * @package    Beaver SDK
 * @version    0.1.0
 * @author     Franco <onidesk@outlook.com>
 * @copyright  2026 Onidesk
 * @license    GPL-3.0-or-later <https://www.gnu.org/licenses/gpl-3.0.txt>
 * @link       https://github.com/Onidesk-TI/beaver-framework
 */

namespace Beaver\Sdk;

final class Manifest
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly string $version,
        public readonly string $namespace,
        public readonly string $main,
        public readonly string $beaverVersion,
        public readonly string $apiVersion,
        public readonly string $author,
        public readonly string $description,
        public readonly array  $permissions,
        public readonly array  $requires,
        public readonly array  $adminMenu,
        public readonly ?string $routes,
        public readonly array  $raw,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name:          $data['name']           ?? '',
            slug:          $data['slug']           ?? '',
            version:       $data['version']        ?? '0.0.0',
            namespace:     $data['namespace']      ?? '',
            main:          $data['main']           ?? '',
            beaverVersion: $data['beaver_version'] ?? '>=0.1.0',
            apiVersion:    $data['api_version']    ?? SdkVersion::API_VERSION,
            author:        $data['author']         ?? '',
            description:   $data['description']    ?? '',
            permissions:   $data['permissions']    ?? [],
            requires:      $data['requires']       ?? [],
            adminMenu:     $data['admin_menu']     ?? [],
            routes:        $data['routes']         ?? null,
            raw:           $data,
        );
    }

    public function className(): string
    {
        return $this->namespace . '\\' . basename($this->main, '.php');
    }

    public function hasPermission(string $scope): bool
    {
        return in_array($scope, $this->permissions, true);
    }
}
PHP

write_file "$SDK_DIR/src/ManifestValidator.php" 664 <<'PHP'
<?php

declare(strict_types=1);

/**
 * Beaver Framework — Modern PHP framework with a plugin ecosystem.
 *
 * @package    Beaver SDK
 * @version    0.1.0
 * @author     Franco <onidesk@outlook.com>
 * @copyright  2026 Onidesk
 * @license    GPL-3.0-or-later <https://www.gnu.org/licenses/gpl-3.0.txt>
 * @link       https://github.com/Onidesk-TI/beaver-framework
 */

namespace Beaver\Sdk;

final class ManifestValidator
{
    private const REQUIRED = ['name', 'slug', 'version', 'namespace', 'main', 'beaver_version'];

    private const ALLOWED_PERMISSIONS = [
        'db.read', 'db.write',
        'http.outbound',
        'fs.read', 'fs.write',
        'hooks.listen', 'hooks.emit',
        'routes.register',
        'views.register',
        'migrations.run',
        'settings.manage',
    ];

    /** @return string[] Lista de erros; vazio = válido. */
    public static function validate(array $manifest): array
    {
        $errors = [];

        foreach (self::REQUIRED as $req) {
            if (empty($manifest[$req])) {
                $errors[] = "Campo obrigatório em falta: $req";
            }
        }

        if (!empty($manifest['slug']) && !preg_match('/^[a-z][a-z0-9_]*$/', $manifest['slug'])) {
            $errors[] = "slug inválido: deve ser snake_case minúsculo (ex: sms_gateway)";
        }

        if (!empty($manifest['version']) && !preg_match('/^\d+\.\d+\.\d+$/', $manifest['version'])) {
            $errors[] = "version inválida: use semver x.y.z";
        }

        if (!empty($manifest['namespace'])
            && !str_starts_with($manifest['namespace'], 'Beaver\\Plugins\\')) {
            $errors[] = "namespace deve começar por 'Beaver\\Plugins\\'";
        }

        if (!empty($manifest['main']) && !preg_match('/\.php$/', $manifest['main'])) {
            $errors[] = "main deve ser um ficheiro .php";
        }

        if (!empty($manifest['api_version'])
            && version_compare($manifest['api_version'], SdkVersion::API_VERSION, '>')) {
            $errors[] = "api_version ({$manifest['api_version']}) superior à do SDK (" . SdkVersion::API_VERSION . ")";
        }

        if (isset($manifest['permissions'])) {
            if (!is_array($manifest['permissions'])) {
                $errors[] = "permissions deve ser um array";
            } else {
                foreach ($manifest['permissions'] as $p) {
                    if (!in_array($p, self::ALLOWED_PERMISSIONS, true)) {
                        $errors[] = "permissão desconhecida: $p";
                    }
                }
            }
        }

        return $errors;
    }

    public static function allowedPermissions(): array
    {
        return self::ALLOWED_PERMISSIONS;
    }
}
PHP

write_file "$SDK_DIR/src/HooksCatalog.php" 664 <<'PHP'
<?php

declare(strict_types=1);

/**
 * Beaver Framework — Modern PHP framework with a plugin ecosystem.
 *
 * @package    Beaver SDK
 * @version    0.1.0
 * @author     Franco <onidesk@outlook.com>
 * @copyright  2026 Onidesk
 * @license    GPL-3.0-or-later <https://www.gnu.org/licenses/gpl-3.0.txt>
 * @link       https://github.com/Onidesk-TI/beaver-framework
 */

namespace Beaver\Sdk;

final class HooksCatalog
{
    // Ciclo de vida
    public const APP_BOOTED    = 'app.booted';
    public const PLUGIN_BOOTED = 'plugin.booted';

    // Encomendas
    public const ORDER_PLACED    = 'order.placed';
    public const ORDER_PAID      = 'order.paid';
    public const ORDER_CANCELLED = 'order.cancelled';
    public const ORDER_SHIPPED   = 'order.shipped';

    // Clientes
    public const CUSTOMER_CREATED = 'customer.created';
    public const CUSTOMER_UPDATED = 'customer.updated';

    // HTTP
    public const HTTP_REQUEST  = 'http.request';
    public const HTTP_RESPONSE = 'http.response';

    // UI / Views
    public const ADMIN_MENU    = 'admin.menu';
    public const VIEW_RENDERED = 'view.rendered';

    /** @return array<string,string> */
    public static function all(): array
    {
        return (new \ReflectionClass(self::class))->getConstants();
    }
}
PHP

write_file "$SDK_DIR/src/Testing/FakeHooks.php" 664 <<'PHP'
<?php

declare(strict_types=1);

/**
 * Beaver Framework — Modern PHP framework with a plugin ecosystem.
 *
 * @package    Beaver SDK
 * @version    0.1.0
 * @author     Franco <onidesk@outlook.com>
 * @copyright  2026 Onidesk
 * @license    GPL-3.0-or-later <https://www.gnu.org/licenses/gpl-3.0.txt>
 * @link       https://github.com/Onidesk-TI/beaver-framework
 */

namespace Beaver\Sdk\Testing;

use Beaver\Plugin\Hooks;

final class FakeHooks extends Hooks
{
    /** @var array<int,array{event:string,args:array}> */
    private array $emitted = [];

    public function emit(string $event, mixed ...$args): array
    {
        $this->emitted[] = ['event' => $event, 'args' => $args];
        return parent::emit($event, ...$args);
    }

    public function emitted(string $event): array
    {
        return array_values(array_filter(
            $this->emitted,
            fn ($e) => $e['event'] === $event
        ));
    }

    public function wasEmitted(string $event): bool
    {
        return $this->emitted($event) !== [];
    }

    public function allEmitted(): array
    {
        return $this->emitted;
    }

    public function reset(): void
    {
        $this->emitted = [];
    }
}
PHP

write_file "$SDK_DIR/src/Testing/PluginTester.php" 664 <<'PHP'
<?php

declare(strict_types=1);

/**
 * Beaver Framework — Modern PHP framework with a plugin ecosystem.
 *
 * @package    Beaver SDK
 * @version    0.1.0
 * @author     Franco <onidesk@outlook.com>
 * @copyright  2026 Onidesk
 * @license    GPL-3.0-or-later <https://www.gnu.org/licenses/gpl-3.0.txt>
 * @link       https://github.com/Onidesk-TI/beaver-framework
 */

namespace Beaver\Sdk\Testing;

use Beaver\Plugin\PluginBase;
use Beaver\Sdk\Manifest;
use Beaver\Sdk\ManifestValidator;

final class PluginTester
{
    public FakeHooks $hooks;
    public array $validationErrors = [];
    public ?PluginBase $instance = null;

    private function __construct(
        private string $pluginClass,
        private string $pluginPath,
        private array  $manifestData,
    ) {
        $this->hooks = new FakeHooks();
    }

    public static function for(string $pluginClass, string $pluginPath): self
    {
        $pluginPath   = rtrim($pluginPath, '/');
        $manifestFile = $pluginPath . '/plugin.json';

        if (!is_file($manifestFile)) {
            throw new \RuntimeException("plugin.json não encontrado em $pluginPath");
        }

        $data = json_decode((string) file_get_contents($manifestFile), true);
        if (!is_array($data)) {
            throw new \RuntimeException("plugin.json inválido (JSON malformado)");
        }

        return new self($pluginClass, $pluginPath, $data);
    }

    public function validateManifest(): self
    {
        $this->validationErrors = ManifestValidator::validate($this->manifestData);
        return $this;
    }

    public function manifest(): Manifest
    {
        return Manifest::fromArray($this->manifestData);
    }

    public function boot(): self
    {
        $main = $this->pluginPath . '/' . ($this->manifestData['main'] ?? 'Plugin.php');

        if (is_file($main) && !class_exists($this->pluginClass)) {
            require_once $main;
        }

        if (!class_exists($this->pluginClass)) {
            throw new \RuntimeException("Classe não encontrada: {$this->pluginClass}");
        }

        $this->instance = new $this->pluginClass($this->pluginPath, $this->manifestData);
        $this->hooks->emit('plugin.booted', $this->instance);
        $this->instance->boot();

        return $this;
    }
}
PHP

echo
echo "==> Ficheiros gerados:"
find "$SDK_DIR" -type f | sort | sed 's|^|    |'

echo
echo "✔ SDK gerado com sucesso."
