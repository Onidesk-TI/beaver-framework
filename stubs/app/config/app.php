<?php

/**
 * Beaver Framework — Modern PHP framework with a plugin ecosystem.
 *
 * @package    Beaver Framework
 * @version    0.1.0
 * @author     Franco <onidesk@outlook.com>
 * @copyright  2026 Onidesk
 * @license    GPL-3.0-or-later <https://www.gnu.org/licenses/gpl-3.0.txt>
 * @link       https://github.com/Onidesk-TI/beaver-framework
 */

// config/app.php — configuração central do Beaver

return [

    /*
    |--------------------------------------------------------------------------
    | Aplicação
    |--------------------------------------------------------------------------
    */
    'name'      => getenv('APP_NAME')  ?: 'Beaver Framework',
    'env'       => getenv('APP_ENV')   ?: 'local',       // local | staging | production
    'debug'     => filter_var(getenv('APP_DEBUG') ?: 'true', FILTER_VALIDATE_BOOL),
    'url'       => getenv('APP_URL')   ?: 'http://localhost:8080',
    'timezone'  => 'Europe/Lisbon',
    'locale'    => 'pt_PT',
    'base_path' => dirname(__DIR__),

    /*
    |--------------------------------------------------------------------------
    | Service Providers
    |--------------------------------------------------------------------------
    | Cada provider tem métodos register() e boot().
    | A ordem importa — são executados de cima para baixo.
    */
    'providers' => [
        \Beaver\Foundation\Providers\ConfigServiceProvider::class,
        \Beaver\Foundation\Providers\ViewServiceProvider::class,
        \Beaver\Foundation\Providers\DatabaseServiceProvider::class,
        \Beaver\Foundation\Providers\HttpServiceProvider::class,
        \Beaver\Foundation\Providers\PluginServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Views
    |--------------------------------------------------------------------------
    */
    'views' => [
        'path'   => dirname(__DIR__) . '/app/views',
        'cache'  => dirname(__DIR__) . '/storage/cache/views',
        'layout' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins
    |--------------------------------------------------------------------------
    | mode controla de onde os plugins são carregados:
    |   dev     → dev_path + staging + prod
    |   staging → staging_path + prod
    |   prod    → apenas path (ignora dev/staging)
    */
    'plugins' => [
        'autoload'      => true,
        'mode'          => getenv('BEAVER_PLUGIN_MODE') ?: 'prod',

        // Produção (publicados, root:www-data)
        'path'          => dirname(__DIR__) . '/app/plugins',

           // NOVO: plugins internos do framework (fazem parte do Beaver)
        'internal_path' => getenv('BEAVER_FRAMEWORK_PATH') ?: dirname(__DIR__) . '/plugins',

        // Desenvolvimento (fora do framework — /var/www/onidesk/beaver-plugins)
        'dev_path'      => getenv('BEAVER_DEV_PLUGINS_PATH') ?: null,

        // Staging (opcional, dentro do framework)
        'staging_path'  => dirname(__DIR__) . '/app/plugins/.staging',

        'require_signature' => false,

        // Permissões (SDK): off | audit | enforce
        //   off     → não verifica nada
        //   audit   → registra no log, não bloqueia
        //   enforce → bloqueia com PermissionDeniedException
        'permissions' => [
            'mode' => getenv('BEAVER_PERMISSIONS_MODE') ?: 'audit',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Rotas
    |--------------------------------------------------------------------------
    */
    'routes' => [
        'web' => dirname(__DIR__) . '/routes/web.php',
        'api' => dirname(__DIR__) . '/routes/api.php',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sessões
    |--------------------------------------------------------------------------
    */
    'session' => [
        'driver'   => 'file',           // file | database | redis
        'name'     => 'beaver_session',
        'lifetime' => 120,              // minutos
        'path'     => dirname(__DIR__) . '/storage/sessions',
    ],

    /*
    |--------------------------------------------------------------------------
    | Segurança
    |--------------------------------------------------------------------------
    */
    'security' => [
        'key'             => getenv('APP_KEY') ?: '',
        'csrf_enabled'    => true,
       'csrf_except' => [
    '/beaver/plugins/sms/send',
    '/sms/send-list'],  // rotas sem CSRF (webhook, api)
        'trusted_proxies' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Aliases (Facades)
    |--------------------------------------------------------------------------
    | Permite usar Route::get(...) em vez de \Beaver\Http\Router::current()->get(...)
    */
    'aliases' => [
        'App'       => \Beaver\Foundation\Application::class,
        'Config'    => \Beaver\Foundation\Config::class,
        'View'      => \Beaver\View\View::class,
        'Route'     => \Beaver\Http\Router::class,
        'Request'   => \Beaver\Http\Request::class,
        'Response'  => \Beaver\Http\Response::class,
        'DB'        => \Beaver\Database\Connection::class,
        'Model'     => \Beaver\Database\Model::class,
        'Hooks'     => \Beaver\Plugin\Hooks::class,
    ],

];
