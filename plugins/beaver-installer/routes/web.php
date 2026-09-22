<?php

/**
 * Beaver Installer — Rotas
 *
 * @var \Beaver\Http\Router $router
 * @var \Beaver\Plugins\BeaverInstaller\InstallerPlugin $plugin
 */

use Beaver\Http\Middleware\RequireAuth;
use Beaver\Plugins\BeaverInstaller\Controllers\InstallerController;

$c = new InstallerController();

$router->get('/admin/plugins',                [$c, 'index'],    [RequireAuth::class]);
$router->get('/admin/plugins/list',           [$c, 'list'],     [RequireAuth::class]);
$router->post('/admin/plugins/install',       [$c, 'install'],  [RequireAuth::class]);
$router->post('/admin/plugins/{slug}/toggle', [$c, 'toggle'],   [RequireAuth::class]);
$router->post('/admin/plugins/{slug}/enable', [$c, 'enable'],   [RequireAuth::class]);
$router->post('/admin/plugins/{slug}/disable',[$c, 'disable'],  [RequireAuth::class]);
$router->post('/admin/plugins/{slug}/remove', [$c, 'remove'],   [RequireAuth::class]);
