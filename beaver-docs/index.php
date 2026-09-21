<?php

/**
 * Beaver Framework — Modern PHP framework with a plugin ecosystem.
 *
 * @package    Beaver Framework
 * @version    0.1.0
 * @author     Franco <onidesk@outlook.com>
 * @copyright  2026 Onidesk
 * @license    GPL-3.0-or-later <https://www.gnu.org/licenses/gpl-3.0.txt>
 * @link       https://github.com/Onidesk-TI/beaver-framework
 */
$navItems = require __DIR__ . '/partials/nav.php';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🦫 Beaver Framework — Documentação</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
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
            padding: 4rem 1.5rem 3rem;
            position: relative;
            overflow: hidden;
            text-align: center;
        }
        .beaver-hero::after {
            content: "";
            position: absolute;
            top: -60px; right: -60px;
            width: 260px; height: 260px;
            background: radial-gradient(circle, rgba(201,138,79,0.3) 0%, transparent 70%);
            border-radius: 50%;
        }
        .icon-badge {
            width: 72px; height: 72px; border-radius: 16px;
            background: linear-gradient(135deg, var(--beaver-oak-light), var(--beaver-oak));
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 10px 24px rgba(160,105,61,0.4);
            font-size: 2rem; margin: 0 auto 1rem;
        }
        .beaver-tagline { color: var(--beaver-oak-light); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; font-size: 0.85rem; }
        .beaver-back { color: var(--beaver-oak-light); text-decoration: none; font-weight: 600; }
        .beaver-back:hover { color: white; }
        .container-topics { max-width: 1200px; margin: 0 auto; padding: 3rem 1.5rem; }
        .beaver-topic-card {
            background: white; border: 1px solid rgba(160,105,61,0.15); border-radius: 14px;
            padding: 1.5rem; height: 100%; text-decoration: none; color: inherit; display: block;
            transition: transform .15s, box-shadow .15s;
        }
        .beaver-topic-card:hover { transform: translateY(-4px); box-shadow: 0 12px 28px rgba(74,44,29,0.15); color: inherit; }
        .beaver-topic-card .icon {
            width: 46px; height: 46px; border-radius: 12px;
            background: var(--beaver-walnut); color: var(--beaver-cream);
            display: flex; align-items: center; justify-content: center; margin-bottom: .8rem; font-size: 1.1rem;
        }
        .beaver-topic-card h5 { font-weight: 700; color: var(--beaver-walnut-dark); }
        .beaver-topic-card p { color: #6b5544; font-size: 0.88rem; margin-bottom: 0; }
        .badge-new { background: #2ec4b6; color: white; font-size: 0.65rem; }
    </style>
</head>
<body>

    <div class="beaver-hero">
        <a href="/about-onidesk-ti.php" class="beaver-back position-absolute top-0 start-0 m-3">
            <i class="fas fa-arrow-left me-1"></i> Voltar
        </a>
        <div class="icon-badge">🦫</div>
        <div class="beaver-tagline">Documentação Oficial</div>
        <h1 class="fw-bold">Beaver Framework</h1>
        <p class="lead" style="opacity:0.9;">A evolução do WebExpress CMS — ORM completo, arquitetura moderna, PHP 8.5 nativo e ferramentas de segurança integradas.</p>
    </div>

    <div class="container-topics">
        <div class="row g-3">
            <?php
            $descriptions = [
                'instalacao'  => 'Requisitos, Composer e configuração inicial da base de dados.',
                'estrutura'   => 'Organização de pastas de um projeto Beaver padrão.',
                'routing'     => 'Definição de rotas, grupos, middleware e parâmetros.',
                'controllers' => 'Controllers, validação de pedidos e respostas.',
                'orm'         => 'Models, relações, query builder fluente e mutators.',
                'migrations'  => 'Versionamento de esquema de base de dados multi-SGBD.',
                'seeders'     => 'Popular a base de dados com dados de teste e factories.',
                'views'       => 'Sistema de templates compatível com sintaxe Blade.',
                'cache'       => 'Camada de cache com drivers file, redis e array.',
                'commands'    => 'Criar comandos CLI próprios, à semelhança do artisan.',
                'frankenphp'  => 'Runtime de alta performance com scanner de segurança integrado.',
                'exemplo'     => 'Um CRUD completo do routing à view, em poucas linhas.',
            ];
            $novos = ['seeders', 'cache', 'commands', 'frankenphp'];
            foreach ($navItems as $item):
            ?>
            <div class="col-md-6 col-lg-4">
                <a href="<?= $item['file'] ?>" class="beaver-topic-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="icon"><i class="fas <?= $item['icon'] ?>"></i></div>
                        <?php if (in_array($item['slug'], $novos, true)): ?>
                            <span class="badge badge-new">NOVO</span>
                        <?php endif; ?>
                    </div>
                    <h5><?= htmlspecialchars($item['label']) ?></h5>
                    <p><?= htmlspecialchars($descriptions[$item['slug']] ?? '') ?></p>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>
