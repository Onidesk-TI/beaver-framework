<?php
// partials/nav.php — lista central de secções da documentação
return [
    ['slug' => 'instalacao',  'label' => 'Instalação',            'icon' => 'fa-download',        'file' => 'instalacao.php'],
    ['slug' => 'estrutura',   'label' => 'Estrutura de Pastas',   'icon' => 'fa-folder-tree',     'file' => 'estrutura.php'],
    ['slug' => 'routing',     'label' => 'Routing',               'icon' => 'fa-route',           'file' => 'routing.php'],
    ['slug' => 'controllers', 'label' => 'Controllers',           'icon' => 'fa-diagram-project', 'file' => 'controllers.php'],
    ['slug' => 'orm',         'label' => 'ORM & Models',          'icon' => 'fa-cubes',           'file' => 'orm.php'],
    ['slug' => 'migrations',  'label' => 'Migrations',            'icon' => 'fa-database',        'file' => 'migrations.php'],
    ['slug' => 'seeders',     'label' => 'Seeders',               'icon' => 'fa-seedling',        'file' => 'seeders.php'],
    ['slug' => 'views',       'label' => 'Views (Templates)',     'icon' => 'fa-window-restore',  'file' => 'views.php'],
    ['slug' => 'cache',       'label' => 'Cache',                 'icon' => 'fa-bolt',            'file' => 'cache.php'],
    ['slug' => 'commands',    'label' => 'Commands (CLI custom)', 'icon' => 'fa-terminal',        'file' => 'commands.php'],
    ['slug' => 'testing', 'label' => 'Unity Test', 'icon' => 'fa-bug', 'file' => 'testing.php'],
    ['slug' => 'certify', 'label' => 'Certify (HTTPS)', 'icon' => 'fa-shield-alt', 'file' => 'certify.php'],
    ['slug' => 'i18n', 'label' => 'Linguagens (i18n)', 'icon' => 'fa-language', 'file' => 'i18n.php'],
    ['slug' => 'dbscope', 'label' => 'DbScope (Base de Dados)', 'icon' => 'fa-database', 'file' => 'dbscope.php'],
    ['slug' => 'plugins', 'label' => 'Plugins', 'icon' => 'fa-puzzle-piece', 'file' => 'plugins.php'],
    ['slug' => 'jobs',        'label' => 'Jobs (Filas)',          'icon' => 'fa-layer-group',     'file' => 'jobs.php'],
    ['slug' => 'frankenphp',  'label' => 'FrankenPHP & Segurança','icon' => 'fa-shield-halved',   'file' => 'frankenphp.php'],
    ['slug' => 'exemplo',     'label' => 'Exemplo Completo',      'icon' => 'fa-flag-checkered',  'file' => 'exemplo.php'],
];
