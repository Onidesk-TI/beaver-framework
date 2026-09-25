# Hello Beaver

Plugin do Beaver Framework.

- **Slug:** `hello-beaver`
- **Namespace:** `Beaver\Plugins\HelloBeaver`
- **Versão:** 0.1.0

## Estrutura

- `src/HelloBeaverPlugin.php` — classe principal (extends `PluginBase`)
- `routes/web.php` — rotas HTTP
- `resources/views/` — templates do plugin
- `lang/` — traduções
- `config/settings.php` — configuração

## Validar

    php beaver plugin:validate hello-beaver
    php beaver plugin:info hello-beaver