<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($title ?? 'Beaver Framework') ?></title>
<meta name="description" content="Beaver Framework — o framework PHP que constrói barragens sólidas.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/resources/ui/css/beaver.css">
</head>
<body>

<!-- SVG sprite -->
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
    <symbol id="ico-gh" viewBox="0 0 24 24">
      <path d="M12 .5C5.7.5.5 5.7.5 12c0 5.1 3.3 9.4 7.9 10.9.6.1.8-.2.8-.6v-2c-3.2.7-3.9-1.5-3.9-1.5-.5-1.3-1.3-1.7-1.3-1.7-1.1-.7.1-.7.1-.7 1.2.1 1.8 1.2 1.8 1.2 1 1.8 2.7 1.3 3.4 1 .1-.8.4-1.3.7-1.6-2.6-.3-5.3-1.3-5.3-5.8 0-1.3.5-2.3 1.2-3.1-.1-.3-.5-1.5.1-3.1 0 0 1-.3 3.3 1.2a11.5 11.5 0 016 0C17.6 4.7 18.6 5 18.6 5c.6 1.6.2 2.8.1 3.1.8.8 1.2 1.8 1.2 3.1 0 4.5-2.7 5.5-5.3 5.8.4.4.8 1.1.8 2.2v3.3c0 .3.2.7.8.6 4.6-1.5 7.9-5.8 7.9-10.9C23.5 5.7 18.3.5 12 .5z"/>
    </symbol>
    <symbol id="ico-repo" viewBox="0 0 24 24">
      <path d="M4 4a2 2 0 0 1 2-2h11a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 0-1 1 1 1 0 0 0 1 1h13a1 1 0 0 0 1-1v-1h1.5a.5.5 0 0 1 .5.5V21a2 2 0 0 1-2 2H6a3 3 0 0 1-3-3V4zm3 1v9l2.5-1.6L12 14V5H7z"/>
    </symbol>
    <symbol id="ico-key" viewBox="0 0 24 24">
      <path d="M14.5 2a5.5 5.5 0 0 0-5.4 6.5L2 15.6V19h3.4l1-1v-1.4H8v-1.4h1.4v-1.4l1.1-1.1A5.5 5.5 0 1 0 14.5 2zm1.7 4.7a1.4 1.4 0 1 1 0-2.8 1.4 1.4 0 0 1 0 2.8z"/>
    </symbol>
    <symbol id="ico-sql" viewBox="0 0 24 24">
      <ellipse cx="12" cy="6" rx="8" ry="3"/>
      <path d="M4 6v6c0 1.7 3.6 3 8 3s8-1.3 8-3V6"/>
      <path d="M4 12v6c0 1.7 3.6 3 8 3s8-1.3 8-3v-6"/>
    </symbol>
  </defs>
</svg>

 <!-- //////////////////// render header ////////////////// -->
<?php require __DIR__ . '/partials/header.php'; ?>
 <!-- //////////////////// render header //////////////////-->
<main>
  <section class="card">

    <div class="card-content">
      <div class="pill">
        <span class="pulse-dot"></span>
        Barragem em construção
      </div>

      <svg class="beaver" aria-hidden="true"><use href="#beaver"/></svg>

      <h1>
        Um framework PHP feito<br>
        para <span class="grad">construir sólido</span><br>
        <span class="stroke">sem complicar</span>
      </h1>

      <p class="lead">
        Rápido, modular e sem mágica escondida. Roteamento claro,
        container enxuto e ferramentas que ajudam em vez de atrapalhar.
      </p>

      <div class="cta-row">
        <a href="#docs" class="btn btn-primary">
          Começar agora
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
        </a>
        <a href="https://github.com/Frank-Onidesk/beaver-framework" target="_blank" rel="noopener" class="btn btn-ghost">
          <svg viewBox="0 0 24 24" fill="currentColor"><use href="#ico-gh"/></svg>
          Ver no GitHub
        </a>
      </div>

      <div class="divider">Progresso do projeto</div>

      <div class="progress">
        <div class="progress-bar"></div>
      </div>
      <div class="progress-label">
        <span>troncos roídos</span>
        <b>87%</b>
      </div>

      <p class="home-note">
        <span class="icon">🏡</span>
        Esta é a minha casa oficial — quero fazê-la bem feita.
      </p>
    </div>

    <div class="right-col">

      <aside class="terminal" aria-hidden="true">
        <div class="terminal-bar">
          <div class="terminal-dots"><i></i><i></i><i></i></div>
          <span class="terminal-title">beaver@barragem — ~/build</span>
        </div>
        <div class="terminal-body" id="terminal"></div>
      </aside>

      <nav class="gh-links" aria-label="Repositórios">
        <div class="gh-label">
          <svg><use href="#ico-gh"/></svg>
          Ecossistema
        </div>

        <a class="gh-item beaver" href="https://github.com/Frank-Onidesk/beaver-framework" target="_blank" rel="noopener noreferrer">
          <span class="gh-ico"><svg><use href="#ico-repo"/></svg></span>
          <span class="gh-body">
            <strong>Beaver Framework</strong>
            <small>framework principal</small>
          </span>
          <svg class="gh-arrow" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H9M17 7v8"/></svg>
        </a>

        <a class="gh-item frankey" href="https://github.com/Frank-Onidesk/frankeiphp" target="_blank" rel="noopener noreferrer">
          <span class="gh-ico"><svg><use href="#ico-key"/></svg></span>
          <span class="gh-body">
            <strong>Frankey</strong>
            <small>autenticação e sessões</small>
          </span>
          <svg class="gh-arrow" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H9M17 7v8"/></svg>
        </a>

        <a class="gh-item sql" href="https://beaverphp.com/sqlwizard" target="_blank" rel="noopener noreferrer">
          <span class="gh-ico"><svg><use href="#ico-sql"/></svg></span>
          <span class="gh-body">
            <strong>SqlAnalyser</strong>
            <small>Community version</small>
          </span>
          <svg class="gh-arrow" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H9M17 7v8"/></svg>
        </a>
      </nav>

    </div>

  </section>
</main>

<footer>
  © <?= htmlspecialchars($year ?? date('Y')) ?> Beaver Framework · Feito com <span class="accent">🦫</span> em Portugal
</footer>

<script src="/resources/ui/js/beaver.js"></script>
</body>
</html>