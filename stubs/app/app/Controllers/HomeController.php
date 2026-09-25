<?php

/**
 * HomeController — controller de boas-vindas.
 *
 * Demonstra o padrão: recebe Request, devolve Response.
 */

declare(strict_types=1);

namespace App\Controllers;

use Beaver\Http\Request;
use Beaver\Http\Response;

class HomeController
{
    public function index(Request $request): Response
    {
        return Response::html(
            view('home/index', [
                'title' => beaver_version() . ' — ' . (getenv('APP_NAME') ?: 'Beaver'),
            ])
        );
    }
}
