<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Beaver Skeleton — Plugin de exemplo</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/plugins/beaver-skeleton/css/beaver-skeleton.css">
</head>
<body>

<main class="sk">

  <header class="sk-head">
    <span class="sk-logo">🦫</span>
    <div>
      <h1>Beaver <span class="sk-accent">Skeleton</span></h1>
      <p class="sk-sub">Plugin de exemplo · Beaver Framework</p>
    </div>
  </header>

  <section class="sk-pill">
    <span class="sk-dot"></span>
    Plugin carregado com sucesso
  </section>

  <section class="sk-grid">

    <article class="sk-card">
      <span class="sk-icon">📁</span>
      <h2>Estrutura</h2>
      <p>Edita <code>resources/views/index.php</code> para começar.</p>
    </article>

    <article class="sk-card">
      <span class="sk-icon">🛣️</span>
      <h2>Rotas</h2>
      <p>As rotas vivem em <code>routes/web.php</code> e são carregadas no <code>boot()</code>.</p>
    </article>

    <article class="sk-card">
      <span class="sk-icon">🎨</span>
      <h2>Assets</h2>
      <p>CSS em <code>resources/ui/css/</code>, JS em <code>resources/ui/js/</code>.</p>
    </article>

    <article class="sk-card">
      <span class="sk-icon">⚙️</span>
      <h2>Manifest</h2>
      <p>Metadados do plugin em <code>plugin.json</code>.</p>
    </article>

  </section>

  <section class="sk-code">
    <button class="sk-copy" type="button" data-copy>Copiar</button>
    <pre><code>php -S localhost:9000 -t public public/index.php</code></pre>
  </section>

  <footer class="sk-foot">
    Beaver Skeleton <code>v0.1.0</code> · feito com <span class="sk-accent">🦫</span> em Portugal
  </footer>

</main>

<script src="/plugins/beaver-skeleton/js/beaver-skeleton.js"></script>
</body>
</html>
