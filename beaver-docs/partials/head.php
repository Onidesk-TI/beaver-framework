<?php
// partials/head.php
// Espera que a página que inclui isto já tenha definido:
// $pageTitle (string), $pageSubtitle (string), $activeSlug (string)

$navItems = require __DIR__ . '/nav.php';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🦫 <?= htmlspecialchars($pageTitle) ?> — Beaver Framework</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" rel="stylesheet">
    <style>
        :root {
            --beaver-walnut: #4A2C1D;
            --beaver-walnut-dark: #2E1A10;
            --beaver-oak: #A0693D;
            --beaver-oak-light: #C98A4F;
            --beaver-cream: #F5EBD8;
        }
        body { background: #FAF6EF; color: var(--beaver-walnut-dark); font-family: -apple-system, 'Segoe UI', sans-serif; }
        .beaver-hero {
            background: linear-gradient(135deg, var(--beaver-walnut) 0%, var(--beaver-walnut-dark) 100%);
            color: var(--beaver-cream);
            padding: 3rem 1.5rem 2.5rem;
            position: relative;
            overflow: hidden;
        }
        .beaver-hero::after {
            content: "";
            position: absolute;
            top: -60px; right: -60px;
            width: 260px; height: 260px;
            background: radial-gradient(circle, rgba(201,138,79,0.3) 0%, transparent 70%);
            border-radius: 50%;
        }
        .beaver-hero .icon-badge {
            width: 60px; height: 60px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--beaver-oak-light), var(--beaver-oak));
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 20px rgba(160,105,61,0.4);
            font-size: 1.7rem;
        }
        .beaver-tagline { color: var(--beaver-oak-light); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; font-size: 0.8rem; }
        .beaver-back { color: var(--beaver-oak-light); text-decoration: none; font-weight: 600; }
        .beaver-back:hover { color: white; }
        .beaver-layout { display: flex; max-width: 1300px; margin: 0 auto; padding: 2.5rem 1.5rem; gap: 2.5rem; }
        .beaver-sidebar { width: 260px; flex-shrink: 0; position: sticky; top: 20px; align-self: flex-start; max-height: calc(100vh - 40px); overflow-y: auto; }
        .beaver-sidebar .nav-link { color: #6b5544; font-weight: 500; border-radius: 8px; padding: 0.5rem 0.9rem; }
        .beaver-sidebar .nav-link:hover { background: var(--beaver-cream); color: var(--beaver-walnut-dark); }
        .beaver-sidebar .nav-link.active { background: var(--beaver-oak); color: white; font-weight: 700; }
        .beaver-content { flex: 1; min-width: 0; }
        .beaver-section h2 {
            color: var(--beaver-walnut-dark);
            font-weight: 800;
            border-bottom: 3px solid var(--beaver-oak);
            padding-bottom: 0.6rem;
            margin-bottom: 1.2rem;
        }
        .beaver-section h2 i { color: var(--beaver-oak); margin-right: 0.5rem; }
        .beaver-card { background: white; border: 1px solid rgba(160,105,61,0.15); border-radius: 12px; padding: 1.5rem; margin-bottom: 1.2rem; }
        pre { border-radius: 10px; margin: 0; }
        code.inline-code { background: var(--beaver-cream); color: var(--beaver-walnut-dark); padding: 2px 6px; border-radius: 4px; font-size: 0.9em; }
        .badge-beaver { background: var(--beaver-oak); color: white; }
        .badge-beaver-danger { background: #8c3a2b; color: white; }
        .beaver-pager { display: flex; justify-content: space-between; margin-top: 2.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(160,105,61,0.2); }
        .beaver-pager a { color: var(--beaver-walnut-dark); text-decoration: none; font-weight: 600; }
        .beaver-pager a:hover { color: var(--beaver-oak); }
        .beaver-topic-card { background: white; border: 1px solid rgba(160,105,61,0.15); border-radius: 12px; padding: 1.3rem; height: 100%; text-decoration: none; color: inherit; display: block; transition: transform .15s, box-shadow .15s; }
        .beaver-topic-card:hover { transform: translateY(-3px); box-shadow: 0 10px 24px rgba(74,44,29,0.15); color: inherit; }
        .beaver-topic-card .icon { width: 42px; height: 42px; border-radius: 10px; background: var(--beaver-walnut); color: var(--beaver-cream); display: flex; align-items: center; justify-content: center; margin-bottom: .6rem; }
    </style>
</head>
<body>

    <div class="beaver-hero text-center">
        <a href="index.php" class="beaver-back position-absolute top-0 start-0 m-3">
            <i class="fas fa-arrow-left me-1"></i> Índice
        </a>
        <div class="icon-badge mx-auto mb-2">🦫</div>
        <div class="beaver-tagline">Documentação Oficial</div>
        <h1 class="fw-bold h3 mb-1"><?= htmlspecialchars($pageTitle) ?></h1>
        <p class="mb-0" style="opacity:0.9;"><?= htmlspecialchars($pageSubtitle) ?></p>
    </div>

    <div class="beaver-layout">
        <nav class="beaver-sidebar d-none d-lg-block">
            <div class="nav flex-column">
                <?php foreach ($navItems as $item): ?>
                    <a class="nav-link<?= $item['slug'] === $activeSlug ? ' active' : '' ?>" href="<?= $item['file'] ?>">
                        <i class="fas <?= $item['icon'] ?> me-2"></i><?= htmlspecialchars($item['label']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </nav>

        <div class="beaver-content">
