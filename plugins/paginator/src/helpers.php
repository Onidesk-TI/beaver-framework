<?php

if (!function_exists('paginate')) {
    /**
     * Renderiza a paginação.
     *
     * Uso:
     *   echo paginate(3, 12, '/produtos?page=');
     *   echo paginate(['current' => 3, 'total' => 12, 'url' => '/produtos?page=']);
     */
    function paginate($currentOrOpts = 1, int $total = 1, string $url = '?page=', int $window = 2): string
    {
        if (is_array($currentOrOpts)) {
            return \Beaver\Plugins\Paginator\Pager::make($currentOrOpts)->render();
        }
        return \Beaver\Plugins\Paginator\Pager::make([
            'current' => (int) $currentOrOpts,
            'total'   => $total,
            'url'     => $url,
            'window'  => $window,
        ])->render();
    }
}
