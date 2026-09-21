<?php
$docs = [];

$docs['sdk/README.md'] = <<<'MD'
# Beaver SDK

**Plugin API v1.0.0** — contrato oficial para desenvolvimento de plugins no Beaver Framework.

## O que é

Camada estável entre o **core** e os **plugins**:

- Define **o que é um plugin válido** (`plugin.json`)
- Define **como o plugin se liga ao core** (classe `*Plugin extends PluginBase`)
- Define **como declarar permissões** (`db.read`, `network.outbound`, ...)
- Oferece **harness de testes** (`PluginTester`, `FakeHooks`)

O `PluginManager` do core usa este SDK para validar cada plugin antes de o instanciar.

## Quick start

    php beaver plugin:make meu-plugin --author="O teu nome"
    php beaver plugin:validate meu-plugin
    php beaver plugin:info meu-plugin
    composer dump-autoload

## Comandos CLI

| Comando | Descrição |
|---|---|
| `plugin:list [--json]` | Lista plugins do mode ativo |
| `plugin:validate [slug] [--json]` | Valida manifestos |
| `plugin:info <slug> [--json]` | Detalhes de um plugin |
| `plugin:make <nome> [--dest=PATH]` | Cria plugin novo |

`--dest=` aceita paths absolutos (Windows e Unix) e relativos.

## Estrutura de um plugin

    namespace Beaver\Plugins\MeuPlugin;

    use Beaver\Plugin\PluginBase;
    use Beaver\Sdk\HooksCatalog;

    class MeuPluginPlugin extends PluginBase
    {
        public function boot(): void
        {
            $this->loadViews();
            $this->loadTranslations();
            $this->loadRoutes();

            $this->hooks()->on(HooksCatalog::ORDER_PLACED, fn($o) => null);
        }
    }

## Testes

    use Beaver\Sdk\Testing\PluginTester;

    $t = PluginTester::for(MeuPluginPlugin::class, __DIR__ . '/../');
    $t->validateManifest();
    $t->boot();
    $this->assertTrue($t->hooks->wasEmitted('plugin.booted'));

## Ver também

- [MANIFEST.md](MANIFEST.md) — referência do `plugin.json`
- [HOOKS.md](HOOKS.md) — catálogo de hooks
- [CHANGELOG.md](CHANGELOG.md) — histórico

**API:** 1.0.0 · **Framework min:** 0.1.0 · **PHP:** 8.1+ · **Licença:** MIT
MD;

$docs['sdk/MANIFEST.md'] = <<<'MD'
# Referência do plugin.json

Manifesto obrigatório de cada plugin. Validado por `ManifestValidator`.

## Estrutura

    {
        "name":           "Sms Gateway",
        "slug":           "sms-gateway",
        "version":        "1.0.0",
        "author":         "Onidesk",
        "description":    "Envio de SMS",
        "namespace":      "Beaver\\Plugins\\SmsGateway",
        "main":           "src/SmsGatewayPlugin.php",
        "beaver_version": ">=0.1.0",
        "api_version":    "1.0.0",
        "requires":       {"php": ">=8.1", "extensions": ["curl"]},
        "permissions":    ["db.read", "hooks.listen"],
        "admin_menu":     {"label": "SMS", "icon": "fa-comment-sms", "order": 10},
        "routes":         "routes/web.php"
    }

## Obrigatórios

| Campo | Tipo | Exemplo |
|---|---|---|
| `name` | string | `"Sms Gateway"` |
| `slug` | string (kebab-case) | `"sms-gateway"` |
| `version` | string (semver) | `"1.0.0"` |
| `namespace` | string (`Beaver\Plugins\X`) | `"Beaver\\Plugins\\SmsGateway"` |
| `main` | string (ficheiro `.php`) | `"src/SmsGatewayPlugin.php"` |
| `beaver_version` | string | `">=0.1.0"` |

## Opcionais

`author`, `description`, `api_version`, `requires`, `permissions`, `admin_menu`, `routes`.

## Permissões — catálogo

| Grupo | Permissões |
|---|---|
| Dados | `db.read`, `db.write`, `filesystem.read`, `filesystem.write`, `fs.read`, `fs.write` |
| Rede | `network.outbound`, `network.inbound`, `http.outbound`, `http.inbound` |
| Hooks | `hooks.listen`, `hooks.emit` |
| UI/Routing | `routes.register`, `views.register`, `views.render`, `admin.menu` |
| Sistema | `migrations.run`, `settings.read`, `settings.manage` |
| Background | `scheduler.register`, `queue.push` |
| Notificações | `mail.send`, `sms.send` |

## Dois formatos de permissions

Plano:

    "permissions": ["db.read", "hooks.listen"]

Rico (com escopos):

    "permissions": {
        "filesystem": {"read": ["storage/"], "write": ["storage/logs/"]},
        "network":    {"outbound": [{"host": "api.example.com", "port": 443}]}
    }

## Validação

    php beaver plugin:validate meu-plugin

Ver [schema/plugin.schema.json](schema/plugin.schema.json) para o schema formal.
MD;

$docs['sdk/HOOKS.md'] = <<<'MD'
# Catálogo de hooks

Usa as constantes de `Beaver\Sdk\HooksCatalog`.

    use Beaver\Sdk\HooksCatalog;
    $this->hooks()->on(HooksCatalog::ORDER_PLACED, fn($o) => null);

## Ciclo de vida

| Constante | Valor |
|---|---|
| `APP_BOOTED` | `app.booted` |
| `PLUGIN_BOOTED` | `plugin.booted` |

## Encomendas

| Constante | Valor |
|---|---|
| `ORDER_PLACED` | `order.placed` |
| `ORDER_PAID` | `order.paid` |
| `ORDER_CANCELLED` | `order.cancelled` |
| `ORDER_SHIPPED` | `order.shipped` |

## Clientes

| Constante | Valor |
|---|---|
| `CUSTOMER_CREATED` | `customer.created` |
| `CUSTOMER_UPDATED` | `customer.updated` |

## HTTP

| Constante | Valor |
|---|---|
| `HTTP_REQUEST` | `http.request` |
| `HTTP_RESPONSE` | `http.response` |

## UI / Views

| Constante | Valor |
|---|---|
| `ADMIN_MENU` | `admin.menu` |
| `VIEW_RENDERED` | `view.rendered` |

## Filtros

    $this->hooks()->filter('product.price', fn($p) => $p * 1.1);

## Hooks próprios

Emite com prefixo do teu slug:

    $this->hooks()->emit('sms.sent', $message);

## Prioridade

    $this->hooks()->on('order.placed', $cb, priority: 5);

Menor = corre primeiro. Default `10`.

## Ver também

- `Beaver\Sdk\HooksCatalog`
- `Beaver\Plugin\Hooks`
- `Beaver\Sdk\Testing\FakeHooks`
MD;

$docs['sdk/CHANGELOG.md'] = <<<'MD'
# Changelog — Beaver SDK

Formato: [Keep a Changelog](https://keepachangelog.com/pt-BR/1.1.0/)
Versionamento: [SemVer](https://semver.org/lang/pt-BR/).

## [1.0.0] — Plugin API estabilizada

### Adicionado

- `Manifest` — Value Object tipado
- `ManifestValidator` — validação com mensagens claras
- `SdkVersion` — `API_VERSION`, `MIN_FRAMEWORK`, `satisfies()`
- `PluginPaths` — descoberta unificada de paths
- `HooksCatalog` — catálogo de hooks conhecidos
- `Testing\PluginTester` — harness de testes
- `Testing\FakeHooks` — Hooks em memória
- `schema/plugin.schema.json` — JSON Schema draft 2020-12

### Comandos CLI

- `plugin:list`, `plugin:validate`, `plugin:info`, `plugin:make`
- Todos com `--json`
- `plugin:make --dest=` para criar fora do framework

### Integração com o core

- `PluginManager::instantiate()` valida antes de instanciar
- Plugins inválidos são rejeitados com erro claro

### Cross-platform

- Normalização de paths Windows e Unix
- `beaver` é PHP puro (Linux, macOS, Windows)

### Corrigido

- `Array to string conversion` em permissões ricas
- Slugs com hífen passam validação

## [Unreleased]

### Planeado

- Enforcement real de permissões
- `plugin:enable` / `plugin:disable`
- `plugin:make --template=`
- Assinatura criptográfica de plugins
MD;

$written = 0;
foreach ($docs as $path => $content) {
    $dir = dirname($path);
    if (!is_dir($dir)) mkdir($dir, 0775, true);
    file_put_contents($path, $content . "\n");
    printf("  + %s (%d linhas)\n", $path, substr_count($content, "\n") + 1);
    $written++;
}

echo "\n$written ficheiro(s) escritos.\n";
