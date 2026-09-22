<?php

/**
 * Menu do Beaver. Define os menus por "contexto".
 * A view só precisa de definir $navContext (default: 'default').
 */

$navContext = $navContext ?? 'default';

$navMenus = [
    // Menu institucional / landing
    'default' => [
        ['label' => 'Home',         'href' => '/',              'icon' => '🏠'],
        ['label' => 'Recursos',     'href' => '/resources',     'icon' => '📦'],
        ['label' => 'Documentação', 'href' => '/documentation', 'icon' => '📚'],
        ['label' => 'Plugins',      'href' => '/plugins',       'icon' => '🔌'],
        ['label' => 'Marketplace',  'href' => '/marketplace',   'icon' => '🛒'],
        ['label' => 'GitHub',       'href' => 'https://github.com/Onidesk-TI/beaver-framework', 'icon' => '🐙', 'external' => true],
    ],

        // Menu do catálogo de plugins / docs
    'sdk' => [
        ['label' => 'Home',    'href' => '/',              'icon' => '🏠'],
        ['label' => 'Plugins', 'href' => '/plugins',       'icon' => '🔌'],
        ['label' => 'Docs',    'href' => '/documentation', 'icon' => '📚'],

        ['label' => 'GitHub',  'href' => 'https://github.com/Onidesk-TI/beaver-framework', 'icon' => '🐙', 'external' => true],
    ],


    // Menu do catálogo de plugins / docs
    'catalog' => [
        ['label' => 'Home',    'href' => '/',              'icon' => '🏠'],
        ['label' => 'Plugins', 'href' => '/plugins',       'icon' => '🔌'],
        ['label' => 'Docs',    'href' => '/documentation', 'icon' => '📚'],
        ['label' => 'GitHub',  'href' => 'https://github.com/Onidesk-TI/beaver-framework', 'icon' => '🐙', 'external' => true],
    ],

    // Menu do marketplace
    'shop' => [
        ['label' => 'Marketplace', 'href' => '/marketplace',          'icon' => '🛒'],
        ['label' => 'Todos',       'href' => '/marketplace/all',      'icon' => '📦'],
        ['label' => 'Destaques',   'href' => '/marketplace/featured', 'icon' => '⭐'],
        ['label' => 'Vender',      'href' => '/marketplace/sellers',  'icon' => '💼'],
        ['label' => 'Docs',        'href' => '/documentation',        'icon' => '📚'],
    ],

    // Menu minimal para auth
    'auth' => [
        ['label' => 'Home',        'href' => '/'],
        ['label' => 'Marketplace', 'href' => '/marketplace'],
    ],
];

// Se a view pedir um contexto inexistente → usa 'default'
$navItems = $navMenus[$navContext] ?? $navMenus['default'];

// Extras opcionais por página
$navItems = array_merge($navItems, $navExtra ?? []);

$current = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
?>
<nav class="beaver-nav" aria-label="Navegação principal">
    <?php foreach ($navItems as $item) :
        $href       = $item['href'];
        $isExternal = !empty($item['external']);
        $isActive = !$isExternal && (
            $current === $href ||
            ($href !== '/' && str_starts_with($current, $href))
        );
        ?>
        <a
            href="<?= htmlspecialchars($href, ENT_QUOTES) ?>"
            class="beaver-nav__link<?= $isActive ? ' is-active' : '' ?>"
            <?= $isExternal ? 'target="_blank" rel="noopener noreferrer"' : '' ?>
        >
            <?php if (!empty($item['icon'])) : ?>
                <span class="beaver-nav__icon" aria-hidden="true"><?= $item['icon'] ?></span>
            <?php endif; ?>
            <span class="beaver-nav__label"><?= htmlspecialchars($item['label']) ?></span>
        </a>
    <?php endforeach; ?>
</nav>