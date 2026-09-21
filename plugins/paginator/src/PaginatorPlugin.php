<?php

declare(strict_types=1);

namespace Beaver\Plugins\Paginator;

use Beaver\Plugin\PluginBase;

class PaginatorPlugin extends PluginBase
{
    public function boot(): void
    {
        error_log('[PAGINATOR] boot() path=' . $this->path);
        $this->loadRoutes();
        error_log('[PAGINATOR] boot OK');
    }
}
