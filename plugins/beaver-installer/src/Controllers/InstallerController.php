<?php

declare(strict_types=1);

/**
 * Beaver Installer — Controller
 *
 * @package    Beaver Installer Plugin
 * @license    MIT <https://opensource.org/licenses/MIT>
 */

namespace Beaver\Plugins\BeaverInstaller\Controllers;

use Beaver\Http\Request;
use Beaver\Http\Response;
use Beaver\Plugins\BeaverInstaller\Services\CatalogService;
use Beaver\Plugins\BeaverInstaller\Services\InstallerService;
use Beaver\Plugins\BeaverInstaller\Services\StateService;

class InstallerController
{
    private CatalogService $catalog;
    private InstallerService $installer;
    private StateService $state;
    private string $viewsDir;

    public function __construct()
    {
        $this->state     = new StateService();
        $this->catalog   = new CatalogService($this->state);
        $this->installer = new InstallerService($this->state, $this->catalog);
        $this->viewsDir  = dirname(__DIR__, 2) . '/resources/views';
    }

    /** GET /admin/plugins */
    public function index(Request $req): Response
    {
        $stats     = $this->catalog->stats();
        $installed = $this->catalog->installed();
        $available = $this->catalog->available();

        ob_start();
        require $this->viewsDir . '/index.php';
        return Response::html((string) ob_get_clean());
    }

    /** GET /admin/plugins/list — JSON */
    public function list(Request $req): Response
    {
        return Response::json([
            'stats'     => $this->catalog->stats(),
            'installed' => $this->catalog->installed(),
            'available' => $this->catalog->available(),
        ]);
    }

    /** POST /admin/plugins/{slug}/toggle */
    public function toggle(Request $req, string $slug): Response
    {
        $result = $this->installer->toggle((string) $slug);
        return Response::json($result, $result['ok'] ? 200 : 400);
    }

    /** POST /admin/plugins/{slug}/enable */
    public function enable(Request $req, string $slug): Response
    {
        $result = $this->installer->enable((string) $slug);
        return Response::json($result, $result['ok'] ? 200 : 400);
    }

    /** POST /admin/plugins/{slug}/disable */
    public function disable(Request $req, string $slug): Response
    {
        $result = $this->installer->disable((string) $slug);
        return Response::json($result, $result['ok'] ? 200 : 400);
    }

    /** POST /admin/plugins/{slug}/remove */
    public function remove(Request $req, string $slug): Response
    {
        $result = $this->installer->remove((string) $slug);
        return Response::json($result, $result['ok'] ? 200 : 400);
    }

    /** POST /admin/plugins/install */
    public function install(Request $req): Response
    {
        $slug = (string) $req->input('slug', '');
        $url  = (string) $req->input('url', '');

        if ($slug !== '') {
            $result = $this->installer->installFromMarketplace($slug);
        } elseif ($url !== '') {
            $result = $this->installer->installFromUrl($url);
        } else {
            return Response::json(['ok' => false, 'error' => 'Falta slug ou url'], 400);
        }

        return Response::json($result, $result['ok'] ? 200 : 400);
    }
}
