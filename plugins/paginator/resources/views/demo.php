<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
$base = '/plugins/paginator';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Paginator · Demo</title>
    <link rel="stylesheet" href="<?= $base ?>/css/paginator.css">
    <style>
        body{background:#070A0F;color:#E8EEF6;font-family:system-ui;padding:40px;max-width:900px;margin:0 auto}
        h1{margin-bottom:8px;font-size:1.4rem}
        p.sub{color:#8895A7;font-size:.85rem;margin-bottom:24px}
        h2{margin-top:28px;margin-bottom:10px;font-size:.9rem;color:#95A3B6;font-weight:600;text-transform:uppercase;letter-spacing:.08em}
        .box{background:#131B27;border:1px solid rgba(255,255,255,.08);border-radius:12px;padding:16px 20px}
        code{background:rgba(255,154,60,.1);color:#FFC98F;padding:2px 6px;border-radius:4px;font-size:.82em}
    </style>
</head>
<body>

<h1>Paginator · Demo</h1>
<p class="sub">Componente de paginação — <code>echo paginate(...)</code></p>

<h2>1. Simples</h2>
<div class="box"><?= paginate(3, 12, '/produtos?page=') ?></div>

<h2>2. Com total de registos</h2>
<div class="box">
    <?= paginate([
        'current'    => 4,
        'total'      => 25,
        'url'        => '/produtos?page=',
        'totalItems' => 247,
        'perPage'    => 10,
    ]) ?>
</div>

<h2>3. Compacto (window=1, sem Primeira/Última)</h2>
<div class="box">
    <?= \Beaver\Plugins\Paginator\Pager::make([
        'current'  => 3,
        'total'    => 12,
        'url'      => '/produtos?page=',
        'window'   => 1,
        'showEnds' => false,
    ]) ?>
</div>

<h2>4. Primeira página (Anterior disabled)</h2>
<div class="box"><?= paginate(1, 12, '/produtos?page=') ?></div>

<h2>5. Última página (Próxima disabled)</h2>
<div class="box"><?= paginate(12, 12, '/produtos?page=') ?></div>

<h2>6. Poucas páginas (3)</h2>
<div class="box"><?= paginate(2, 3, '/produtos?page=') ?></div>

<h2>7. Tema claro</h2>
<div class="box" style="background:#fff">
    <div class="paginator is-light" style="padding:0">
        <?php
            $p = \Beaver\Plugins\Paginator\Pager::make([
                'current'    => 4,
                'total'      => 12,
                'url'        => '/produtos?page=',
                'totalItems' => 120,
                'perPage'    => 10,
            ]);
            $html = $p->render();
            echo str_replace('class="paginator"', 'class="paginator is-light"', $html);
        ?>
    </div>
</div>

</body>
</html>
