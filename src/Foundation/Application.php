<?php

/**
 * Beaver Framework — Modern PHP framework with a plugin ecosystem.
 *
 * @package    Beaver Framework
 * @author     Franco <onidesk@outlook.com>
 * @copyright  2026 Onidesk
 * @license    MIT <https://opensource.org/licenses/MIT>
 * @link       https://github.com/Onidesk-TI/beaver-framework
 */

namespace Beaver\Foundation;

use Beaver\Http\{Kernel, Request, Router};
use Beaver\I18n\Locale;
use Beaver\I18n\Translator;
use Beaver\Plugin\PluginManager;
use Beaver\Plugin\Hooks;
use Beaver\View\View;

class Application
{
    private static ?self $instance = null;

    private array $bindings = [];
    private array $instances = [];

    public Config $config;
    public string $basePath;      // alias de $projectPath
    public string $projectPath;   // raiz do projeto (app/, config/, routes/, storage/)
    public string $frameworkPath; // raiz do framework (src/, sdk/, plugins/, stubs/)

    public function __construct(?string $projectPath = null, ?string $frameworkPath = null)
    {
        // Compatibilidade: se só um path é passado, framework = projeto.
        $this->projectPath   = $projectPath   ?? dirname(__DIR__, 2);
        $this->frameworkPath = $frameworkPath ?? $this->projectPath;
        $this->basePath      = $this->projectPath;   // alias BC
        self::$instance = $this;

        //  Load .env first, then register global helpers.
        \Beaver\Foundation\Env::load($this->basePath . '/.env');
        require_once __DIR__ . '/helpers.php';

        //  Config
        $this->config = new Config($this->basePath . '/config');
        $this->config->load();
        $this->instances[Config::class] = $this->config;

        //  Timezone
        date_default_timezone_set($this->config->get('app.timezone', 'UTC'));

        //  Carbon locale (depois de a config existir)
        if (class_exists(\Carbon\CarbonImmutable::class)) {
            \Carbon\CarbonImmutable::setLocale(
                $this->config->get('app.locale', 'pt')
            );
        }

        //  View
        $this->instances[View::class] = new View(
            $this->config->get('app.views.path'),
            $this->config->get('app.views.cache')
        );

        //  Tema ativo (regista ThemeManager + namespace 'theme')
        $this->bootTheme();

        //  Router
        $this->instances[Router::class] = Router::current();

        //  Hooks
        $this->instances[Hooks::class] = new Hooks();

        //  Plugin Manager
        $this->instances[PluginManager::class] = new PluginManager($this);

        //  i18n
        $this->bootI18n();
    }



    public static function getInstance(): self
    {
        if (self::$instance === null) {
            // Fallback: o framework a autoarrancar (sem projeto externo).
            $root = dirname(__DIR__, 2);
            self::$instance = new self($root, $root);
        }
        return self::$instance;
    }

    public function bind(string $abstract, callable $factory): void
    {
        $this->bindings[$abstract] = $factory;
    }

    public function instance(string $abstract, mixed $object): void
    {
        $this->instances[$abstract] = $object;
    }

    public function make(string $abstract): mixed
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }
        if (isset($this->bindings[$abstract])) {
            return $this->instances[$abstract] = ($this->bindings[$abstract])($this);
        }
        if (class_exists($abstract)) {
            return $this->instances[$abstract] = new $abstract();
        }
        throw new \RuntimeException("Cannot resolve: $abstract");
    }

    public function config(?string $key = null, mixed $default = null): mixed
    {
        return $key === null
            ? $this->config->all()
            : $this->config->get($key, $default);
    }


  /**
 * Regista o sistema de temas.
 *
 * - Cria o ThemeManager e guarda-o no container.
 * - Se houver tema ativo, regista o namespace 'theme' no View.
 *
 * Não faz nada se o projeto não tiver config/themes.php.
 */
    protected function bootTheme(): void
    {
        $config = $this->config->get('themes');
        if (!is_array($config)) {
            return;
        }

        $paths = \Beaver\Sdk\Theme\ThemePaths::fromConfig($config);
        $mgr   = new \Beaver\Sdk\Theme\ThemeManager($paths);

        // Registar no container (antes de qualquer uso)
        $this->instances[\Beaver\Sdk\Theme\ThemeManager::class] = $mgr;

        $slug = $mgr->active();
        if ($slug === null) {
            return;
        }

        $dir = $mgr->path($slug);
        if ($dir === null) {
            return;
        }

        $viewsDir = $dir . '/resources/views';
        if (is_dir($viewsDir)) {
            View::registerNamespace('theme', $viewsDir);
        }
    }

    public function boot(): void
    {
        if ($this->config->get('app.plugins.autoload', true)) {
            $this->make(PluginManager::class)->discover()->boot();
        }

        $routesFile = $this->config->get('app.routes.web');
        if (is_file($routesFile)) {
            require $routesFile;
        }
    }

    public function handleHttp(?Request $request = null): void
    {
        $kernel = new Kernel($this);
        $kernel->handle($request ?? Request::capture())->send();
    }


      /**
     * Boot the internationalization layer.
     *
     * Resolution order for the language files:
     *   1. app.lang.path from config (if set)
     *   2. <project>/lang   (project overrides)
     *   3. <framework>/lang (framework defaults)
     */
    protected function bootI18n(): void
    {
        $langPath = $this->config->get('app.lang.path')
            ?? (is_dir($this->basePath . '/lang')
                ? $this->basePath . '/lang'
                : dirname(__DIR__, 2) . '/lang');

        $locale = getenv('BEAVER_LANG') ?: Locale::fromBrowser();

        $translator = new Translator(
            langPath: $langPath,
            locale:   $locale,
            fallback: $this->config->get('app.lang.fallback', 'pt'),
        );

        $this->instances[Translator::class] = $translator;
        Translator::boot($translator);

        $helpers = dirname(__DIR__) . '/I18n/helpers.php';
        if (is_file($helpers)) {
            require_once $helpers;
        }
    }
}
