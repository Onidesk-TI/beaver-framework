<?php

/**
 * Plugins — catálogo do ecossistema Beaver
 * Variáveis esperadas:
 *   $plugins  → array de plugins
 *   $version  → versão do framework
 *   $year     → ano
 */

$plugins = $plugins ?? [];
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Plugins — Beaver Framework</title>
<meta name="description" content="Catálogo de plugins oficiais do Beaver Framework.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/resources/ui/css/plugins.css">
</head>
<body>

<!-- SVG sprite (mesmo da home) -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <defs>
    <linearGradient id="bvg" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="#FFD79A"/>
      <stop offset="48%" stop-color="#FF9A3C"/>
      <stop offset="100%" stop-color="#FF6B35"/>
    </linearGradient>
    <symbol id="beaver" viewBox="0 0 64 64">
      <circle cx="13" cy="17.5" r="7.5" fill="url(#bvg)" opacity=".72"/>
      <circle cx="51" cy="17.5" r="7.5" fill="url(#bvg)" opacity=".72"/>
      <ellipse cx="32" cy="33" rx="23" ry="21" fill="url(#bvg)"/>
      <ellipse cx="32" cy="41" rx="15.5" ry="12" fill="#0A0E14" opacity=".18"/>
      <ellipse cx="32" cy="34.5" rx="4.6" ry="3.2" fill="#1A1208"/>
      <circle cx="22.5" cy="26" r="3.4" fill="#1A1208"/>
      <circle cx="41.5" cy="26" r="3.4" fill="#1A1208"/>
      <circle cx="23.6" cy="25" r="1.1" fill="#FFF6E8" opacity=".9"/>
      <circle cx="42.6" cy="25" r="1.1" fill="#FFF6E8" opacity=".9"/>
      <rect x="27.3" y="44.5" width="4.3" height="10.5" rx="1.7" fill="#FFF6E8"/>
      <rect x="32.4" y="44.5" width="4.3" height="10.5" rx="1.7" fill="#FFF6E8"/>
    </symbol>
    <symbol id="ico-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/>
    </symbol>
    <symbol id="ico-star" viewBox="0 0 24 24" fill="currentColor">
      <path d="M12 2l2.9 6.9L22 10l-5.5 4.7L18.2 22 12 18.3 5.8 22l1.7-7.3L2 10l7.1-1.1L12 2z"/>
    </symbol>
    <symbol id="ico-download" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M12 3v13M6 12l6 6 6-6M4 21h16"/>
    </symbol>
    <symbol id="ico-tag" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
      <circle cx="7" cy="7" r="1.5"/>
    </symbol>
    <symbol id="ico-repo" viewBox="0 0 24 24" fill="currentColor">
      <path d="M4 4a2 2 0 0 1 2-2h11a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 0-1 1 1 1 0 0 0 1 1h13a1 1 0 0 0 1-1v-1h1.5a.5.5 0 0 1 .5.5V21a2 2 0 0 1-2 2H6a3 3 0 0 1-3-3V4zm3 1v9l2.5-1.6L12 14V5H7z"/>
    </symbol>
    <symbol id="ico-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M7 17L17 7M17 7H9M17 7v8"/>
    </symbol>
    <symbol id="ico-home" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M3 11l9-8 9 8v9a2 2 0 0 1-2 2h-4v-6h-6v6H5a2 2 0 0 1-2-2z"/>
    </symbol>
  </defs>
</svg>

<!-- ====== HEADER ====== -->
<header>
  <div class="nav-inner">
    <a href="/" class="brand">
      <span class="brand-logo"><svg><use href="#beaver"/></svg></span>
      <span>
        <span class="brand-name">Beaver<span class="accent">.</span></span>
        <span class="brand-sub">Framework <?= htmlspecialchars($version ?? '') ?></span>
      </span>
    </a>

    <nav class="nav-links">
      <a href="/" class="back-home">
        <svg><use href="#ico-home"/></svg>
        Home
      </a>
      <a href="/plugins" class="active">Plugins</a>
      <a href="/docs">Docs</a>
      <a href="https://github.com/Onidesk-TI" target="_blank" rel="noopener">GitHub</a>
    </nav>
  </div>
</header>

<!-- ====== MAIN ====== -->
<main>

  <section class="page-hero">
    <div class="page-hero-inner">
      <div class="pill">
        <span class="pulse-dot"></span>
        <?= count($plugins) ?> plugins publicados
      </div>
      <h1>
        Ecossistema <span class="grad">Beaver</span>
      </h1>
    <p class="lead">
    Extensões oficiais e da comunidade. Instala em segundos ou cria o teu próprio plugin a partir do
    <a href="https://github.com/Onidesk-TI/beaver-skeleton" target="_blank" rel="noopener"><code>beaver-skeleton</code></a>.
    </p>
    </div>
  </section>

  <!-- ====== FILTROS ====== -->
  <section class="filters" aria-label="Filtros">
    <div class="filters-inner">

      <div class="filter-search">
        <svg><use href="#ico-search"/></svg>
        <input
          type="search"
          id="filter-name"
          placeholder="Procurar por nome, autor ou descrição…"
          autocomplete="off"
        >
      </div>

      <div class="filter-group">
        <label for="filter-category">Categoria</label>
        <select id="filter-category">
          <option value="">Todas</option>
          <option value="devtools">Ferramentas dev</option>
          <option value="auth">Autenticação</option>
          <option value="admin">Admin & UI</option>
          <option value="database">Base de dados</option>
          <option value="mail">Email</option>
          <option value="storage">Storage</option>
          <option value="queue">Filas & Jobs</option>
        </select>
      </div>

      <div class="filter-group">
        <label for="filter-sort">Ordenar</label>
        <select id="filter-sort">
          <option value="stars">Mais estrelas</option>
          <option value="downloads">Mais downloads</option>
          <option value="updated">Atualizados recentemente</option>
          <option value="name">Nome (A–Z)</option>
        </select>
      </div>

      <div class="filter-tags">
        <button class="chip" data-tag="official"  type="button">★ Oficial</button>
        <button class="chip" data-tag="stable"    type="button">Estável</button>
        <button class="chip" data-tag="beta"      type="button">Beta</button>
        <button class="chip" data-tag="new"       type="button">Novo</button>
      </div>

    </div>

    <div class="filters-meta">
      <span id="results-count"><?= count($plugins) ?> plugins</span>
      <button type="button" id="reset-filters" class="link-btn">Limpar filtros</button>
    </div>
  </section>

 <section class="skeleton-banner">
  <h2>Queres criar o teu plugin?</h2>
  <p>Começa pelo esqueleto oficial — estrutura, <code>composer.json</code> e pontos de entrada já configurados.</p>

  <div class="skeleton-cta">
    <div class="code-block">
      <button class="copy-btn" type="button" aria-label="Copiar">Copiar</button>
      <pre><code>git clone https://&lt;seu-token&gt;@github.com/Onidesk-TI/beaver-skeleton.git</code></pre>
    </div>

    <a class="btn btn-primary"
       href="https://github.com/Onidesk-TI/beaver-skeleton"
       target="_blank" rel="noopener">
      Ver no GitHub →
    </a>
  </div>
</section>

  <!-- ====== GRELHA ====== -->
  <section class="grid" id="plugins-grid" aria-live="polite">

    <?php foreach ($plugins as $i => $p) : ?>
      <article
        class="plugin-card"
        data-name="<?= htmlspecialchars(strtolower($p['name'])) ?>"
        data-author="<?= htmlspecialchars(strtolower($p['author'] ?? '')) ?>"
        data-description="<?= htmlspecialchars(strtolower($p['description'] ?? '')) ?>"
        data-category="<?= htmlspecialchars($p['category'] ?? '') ?>"
        data-stars="<?= (int)($p['stars'] ?? 0) ?>"
        data-downloads="<?= (int)($p['downloads'] ?? 0) ?>"
        data-updated="<?= (int)($p['updated_ts'] ?? 0) ?>"
        data-tags="<?= htmlspecialchars(implode(',', $p['tags'] ?? [])) ?>"
      >

       <header class="plugin-head">
  <span class="plugin-icon" style="--h: <?= (int)($p['hue'] ?? 30) ?>">
        <?= htmlspecialchars($p['icon'] ?? '🧩') ?>
  </span>
  <div class="plugin-title">
    <h2>
        <?= htmlspecialchars($p['name']) ?>
        <?php if (!empty($p['official'])) : ?>
        <span class="badge badge-official" title="Oficial">★</span>
        <?php endif; ?>
        <?php if (!empty($p['version'])) : ?>
        <span class="badge badge-version">v<?= htmlspecialchars($p['version']) ?></span>
        <?php endif; ?>
    </h2>
    <p class="plugin-sub">
      por <strong><?= htmlspecialchars($p['author'] ?? 'Onidesk') ?></strong>
      · <span class="cat-label"><?= htmlspecialchars($p['category_label'] ?? $p['category'] ?? '') ?></span>
    </p>
  </div>

  <div class="plugin-head-right">
        <?php if (!empty($p['is_free'])) : ?>
      <span class="price price-free">
        <svg><use href="#ico-gift"/></svg>
        Grátis
      </span>
        <?php elseif (($p['price'] ?? 0) > 0) : ?>
      <span class="price price-paid">
        <small>€</small><?= number_format($p['price'], 2, ',', '.') ?>
      </span>
        <?php endif; ?>

    <a class="repo-btn"
       href="<?= htmlspecialchars($p['repo']) ?>"
       target="_blank" rel="noopener noreferrer"
       aria-label="Ver repositório">
      <svg><use href="#ico-repo"/></svg>
    </a>
  </div>
</header>

        <!-- ====== TABS ====== -->
        <nav class="tabs" role="tablist">
          <button class="tab is-active" data-tab="preview"   role="tab" type="button">Pré-visualização</button>
          <button class="tab"           data-tab="install"   role="tab" type="button">Instalação</button>
          <button class="tab"           data-tab="usage"     role="tab" type="button">Exemplo</button>
        </nav>

        <div class="tab-panels">

          <!-- Preview -->
          <div class="panel is-active" data-panel="preview">
            <div class="screenshot">
              <?php if (!empty($p['screenshot'])) : ?>
                <img src="<?= htmlspecialchars($p['screenshot']) ?>" alt="Screenshot de <?= htmlspecialchars($p['name']) ?>" loading="lazy">
              <?php else : ?>
                <div class="screenshot-placeholder">
                  <span>🖼️</span>
                  <em>Sem screenshot</em>
                </div>
              <?php endif; ?>
            </div>
            <p class="description"><?= htmlspecialchars($p['description'] ?? '') ?></p>
          </div>

          <!-- Instalação -->
        <div class="panel" data-panel="install">

  <p class="panel-note">1. Instalar via Composer:</p>
  <div class="code-block">
    <button class="copy-btn" type="button" aria-label="Copiar">Copiar</button>
    <pre><code>composer require <?= htmlspecialchars($p['composer'] ?? 'onidesk-ti/' . strtolower($p['name'])) ?></code></pre>
  </div>

        <p class="panel-note">2. Ou criar um plugin novo a partir do esqueleto:</p>
        <div class="code-block">
        <button class="copy-btn" type="button" aria-label="Copiar">Copiar</button>
        <pre><code>git clone https://&lt;seu-token&gt;@github.com/Onidesk-TI/beaver-skeleton.git</code></pre>
        </div>

        <?php if (!empty($p['install_notes'])) : ?>
        <p class="panel-note"><?= htmlspecialchars($p['install_notes']) ?></p>
        <?php endif; ?>

        </div>

          <!-- Exemplo -->
          <div class="panel" data-panel="usage">
            <div class="code-block">
              <button class="copy-btn" type="button" aria-label="Copiar">Copiar</button>
              <pre><code><?= htmlspecialchars($p['usage'] ?? "// exemplo em breve") ?></code></pre>
            </div>
          </div>

        </div>

        <!-- ====== FOOTER DO CARD ====== -->
        <footer class="plugin-foot">
          <div class="foot-metrics">
            <span class="metric">
              <svg><use href="#ico-star"/></svg>
              <?= number_format((int)($p['stars'] ?? 0)) ?>
            </span>
            <span class="metric">
              <svg><use href="#ico-download"/></svg>
              <?= number_format((int)($p['downloads'] ?? 0)) ?>
            </span>
            <?php if (!empty($p['updated'])) : ?>
              <span class="metric metric-dim">
                atualizado <?= htmlspecialchars($p['updated']) ?>
              </span>
            <?php endif; ?>
          </div>

          <div class="foot-tags">
            <?php foreach (($p['tags'] ?? []) as $tag) : ?>
              <span class="tag"><?= htmlspecialchars($tag) ?></span>
            <?php endforeach; ?>
          </div>
        </footer>

      </article>
    <?php endforeach; ?>

  </section>

  <!-- Empty state -->
  <div class="empty-state" id="empty-state" hidden>
    <div class="empty-icon">🦫</div>
    <h3>Nenhum plugin encontrado</h3>
    <p>Tenta ajustar os filtros ou limpar a pesquisa.</p>
    <button type="button" class="btn btn-primary" id="empty-reset">Limpar filtros</button>
  </div>

  <!-- ====== PAGINAÇÃO ====== -->
  <nav class="pagination" id="pagination" aria-label="Paginação"></nav>

</main>

<!-- ====== FOOTER ====== -->
<footer>
  © <?= htmlspecialchars($year ?? date('Y')) ?> Beaver Framework · Feito com <span class="accent">🦫</span> em Portugal
</footer>

<script src="/resources/ui/js/plugins.js"></script>
</body>
</html>