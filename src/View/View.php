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

namespace Beaver\View;

class View
{
    /** @var array<string, string> namespaces: ['sms' => '/path/to/views'] */
    private static array $namespaces = [];

    private ?string $defaultLayout = null;

    public function __construct(
        private string $basePath,
        private string $cachePath,
    ) {
        if (!is_dir($this->basePath)) {
            @mkdir($this->basePath, 0775, true);
        }
    }

    public function make(string $view, array $data = [], ?string $layout = null): string
    {
        $content = $this->render($view, $data);

        $layout ??= $this->defaultLayout;
        if ($layout !== null) {
            $content = $this->render($layout, array_merge($data, ['content' => $content]));
        }
        return $content;
    }

    public function render(string $view, array $data = []): string
    {
        $file = $this->resolve($view);

        if (!is_file($file)) {
            throw new \RuntimeException("View não encontrada: $view (esperado em $file)");
        }

        $data['__view'] = $this;

        return $this->evaluate($file, $data);
    }

    public function exists(string $view): bool
    {
        return is_file($this->resolve($view));
    }

    public function setDefaultLayout(?string $layout): self
    {
        $this->defaultLayout = $layout;
        return $this;
    }

    // ---------- namespaces (views de plugins) ----------

    /** View::registerNamespace('sms', '/path/to/views') */
    public static function registerNamespace(string $name, string $path): void
    {
        self::$namespaces[$name] = rtrim($path, '/');
    }

    public static function namespaces(): array
    {
        return self::$namespaces;
    }

    // ---------- internos ----------

    private function resolve(string $view): string
    {
    //  Namespace explícito: 'beaver-admin::login' ou 'theme::index'
        if (str_contains($view, '::')) {
            [$ns, $rest] = explode('::', $view, 2);

            if (!isset(self::$namespaces[$ns])) {
                throw new \RuntimeException("Namespace de views não registado: $ns");
            }

            return self::$namespaces[$ns]
             . '/'
             . str_replace('.', '/', $rest)
             . '.php';
        }

    // Tema ativo tem prioridade (se registado)
        if (isset(self::$namespaces['theme'])) {
            $themeFile = self::$namespaces['theme']
                   . '/'
                   . str_replace('.', '/', $view)
                   . '.php';

            if (is_file($themeFile)) {
                return $themeFile;
            }
        }

    //  Fallback: basePath (skeleton ou app)
        return rtrim($this->basePath, '/')
         . '/'
         . str_replace('.', '/', $view)
         . '.php';
    }

    private function evaluate(string $file, array $data): string
    {
        extract($data, EXTR_SKIP);

        ob_start();
        try {
            include $file;
        } catch (\Throwable $e) {
            ob_end_clean();
            throw $e;
        }
        return (string) ob_get_clean();
    }
}
