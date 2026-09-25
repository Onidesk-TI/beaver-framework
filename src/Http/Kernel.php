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

namespace Beaver\Http;

use Beaver\Foundation\Application;

class Kernel
{
    public function __construct(private Application $app)
    {
    }

    public function handle(Request $request): Response
    {
        try {
            return Router::current()->dispatch($request);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    private function handleException(\Throwable $e): Response
    {
        $debug = (bool) $this->app->config('app.debug', false);

        if ($debug) {
            $html = '<h1>Erro</h1>'
                  . '<p><strong>' . htmlspecialchars(get_class($e)) . '</strong>: '
                  . htmlspecialchars($e->getMessage()) . '</p>'
                  . '<p>' . htmlspecialchars($e->getFile()) . ':' . $e->getLine() . '</p>'
                  . '<pre style="background:#f4f4f4;padding:1em;overflow:auto;">'
                  . htmlspecialchars($e->getTraceAsString()) . '</pre>';
        } else {
            $html = '<h1>500 Internal Server Error</h1>';
        }

        return Response::html($html, 500);
    }
}
