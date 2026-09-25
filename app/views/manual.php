<?php

/**
 * Beaver Framework — Manual
 *
 * Documentação com o mesmo design do progresso diário.
 */

declare(strict_types=1);

?>
<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Beaver · Manual</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<style>
:root{
  --bg:#FAFAF7;
  --surface:#FFFFFF;
  --surface-2:#F4F4EE;
  --text:#1A1208;
  --muted:#6B6B5F;
  --border:rgba(26,18,8,.10);
  --border-2:rgba(26,18,8,.06);
  --accent:#FF6B35;
  --accent-2:#FF9A3C;
  --success:#16A34A;
  --doing:#2563EB;
  --violet:#7C3AED;
  --green:#15803D;
}
[data-theme="dark"]{
  --bg:#070A0F;
  --surface:#131B27;
  --surface-2:#0A0F16;
  --text:#E8EEF6;
  --muted:#8895A7;
  --border:rgba(255,255,255,.10);
  --border-2:rgba(255,255,255,.06);
  --accent:#FF9A3C;
  --accent-2:#FF6B35;
  --success:#4ADE80;
  --doing:#60A5FA;
  --violet:#A78BFA;
  --green:#4ADE80;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%}
body{
  font-family:'Inter',system-ui,-apple-system,sans-serif;
  background:var(--bg);
  color:var(--text);
  line-height:1.65;
  -webkit-font-smoothing:antialiased;
  transition:background .25s, color .25s;
}

/* ── Header ── */
header{
  position:sticky;top:0;z-index:10;
  background:color-mix(in srgb, var(--bg) 88%, transparent);
  backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);
  border-bottom:1px solid var(--border);
  height:56px;
  display:flex;align-items:center;
  padding:0 24px;gap:12px;
}
.logo{
  width:30px;height:30px;border-radius:9px;flex:none;
  display:grid;place-items:center;
  background:linear-gradient(150deg,rgba(255,154,60,.16),rgba(255,107,53,.06));
  border:1px solid rgba(255,154,60,.28);
}
.logo svg{width:19px;height:19px}
.brand{font-weight:800;letter-spacing:-.02em}
.brand .accent{color:var(--accent)}
.sub{font-size:.72rem;color:var(--muted);margin-left:6px}
.back-link{
  margin-left:auto;
  font-size:.85rem;
  color:var(--muted);
  text-decoration:none;
  padding:6px 12px;
  border-radius:8px;
  border:1px solid var(--border);
  background:var(--surface);
  transition:.18s;
}
.back-link:hover{color:var(--accent);border-color:var(--accent)}
.theme-toggle{
  width:34px;height:34px;
  border-radius:9px;
  border:1px solid var(--border);
  background:var(--surface);
  color:var(--text);
  display:grid;place-items:center;
  cursor:pointer;
  transition:.18s;
  flex:none;
}
.theme-toggle:hover{
  border-color:var(--accent);
  color:var(--accent);
  transform:translateY(-1px);
}
.theme-toggle svg{width:16px;height:16px}
[data-theme="light"] .icon-moon{display:none}
[data-theme="dark"]  .icon-sun{display:none}

/* ── Layout ── */
main{
  max-width:920px;
  margin:0 auto;
  padding:40px 24px 80px;
}
h1{
  font-size:clamp(1.6rem,3vw,2.1rem);
  font-weight:800;
  letter-spacing:-.03em;
  margin-bottom:8px;
}
.lead{
  color:var(--muted);
  font-size:.95rem;
  margin-bottom:32px;
}
.lead strong{color:var(--text);font-weight:700}

/* ── TOC ── */
.toc{
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:14px;
  padding:20px 22px;
  margin-bottom:32px;
}
.toc h2{
  font-size:.72rem;
  font-weight:700;
  letter-spacing:.14em;
  text-transform:uppercase;
  color:var(--accent);
  margin-bottom:12px;
}
.toc ul{list-style:none;display:grid;grid-template-columns:repeat(2,1fr);gap:8px 20px}
.toc a{
  color:var(--text);
  text-decoration:none;
  font-size:.88rem;
  display:flex;
  gap:8px;
  align-items:center;
  transition:.15s;
}
.toc a::before{
  content:"→";
  color:var(--muted);
  font-family:'JetBrains Mono',monospace;
  font-size:.82rem;
  transition:.15s;
}
.toc a:hover{color:var(--accent)}
.toc a:hover::before{color:var(--accent);transform:translateX(3px)}

/* ── Grelha de cards ── */
.card-grid{
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
  gap:12px;
  margin-bottom:40px;
}
.card{
  display:flex;
  flex-direction:column;
  gap:6px;
  padding:16px 18px;
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:12px;
  text-decoration:none;
  color:var(--text);
  transition:.2s;
}
.card:hover{
  border-color:color-mix(in srgb, var(--accent) 45%, var(--border));
  box-shadow:0 8px 24px -14px rgba(255,107,53,.3);
  transform:translateY(-2px);
}
.card-icon{
  width:34px;height:34px;
  border-radius:9px;
  display:grid;place-items:center;
  font-size:1rem;
  margin-bottom:4px;
  background:color-mix(in srgb, var(--accent) 12%, transparent);
  border:1px solid color-mix(in srgb, var(--accent) 25%, transparent);
}
.card[data-color="violet"] .card-icon{
  background:color-mix(in srgb, var(--violet) 12%, transparent);
  border-color:color-mix(in srgb, var(--violet) 25%, transparent);
}
.card[data-color="green"] .card-icon{
  background:color-mix(in srgb, var(--green) 12%, transparent);
  border-color:color-mix(in srgb, var(--green) 25%, transparent);
}
.card[data-color="blue"] .card-icon{
  background:color-mix(in srgb, var(--doing) 12%, transparent);
  border-color:color-mix(in srgb, var(--doing) 25%, transparent);
}
.card-title{font-size:.92rem;font-weight:700;letter-spacing:-.01em}
.card-desc{font-size:.78rem;color:var(--muted);line-height:1.5}

/* ── Secções ── */
.section-manual{
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:14px;
  padding:26px 28px;
  margin-bottom:16px;
  scroll-margin-top:80px;
  transition:.2s;
}
.section-manual:hover{
  border-color:color-mix(in srgb, var(--accent) 40%, var(--border));
  box-shadow:0 8px 24px -14px rgba(255,107,53,.25);
}
.section-manual h2{
  font-size:1.15rem;
  font-weight:700;
  letter-spacing:-.015em;
  margin-bottom:14px;
  display:flex;
  align-items:center;
  gap:10px;
}
.section-num{
  font-family:'JetBrains Mono',monospace;
  font-size:.72rem;
  font-weight:600;
  color:var(--accent);
  background:color-mix(in srgb, var(--accent) 12%, transparent);
  border:1px solid color-mix(in srgb, var(--accent) 25%, transparent);
  padding:3px 8px;
  border-radius:6px;
  letter-spacing:.04em;
}
.section-manual h3{font-size:.92rem;font-weight:700;margin:20px 0 10px;letter-spacing:-.01em}
.section-manual p{color:var(--muted);font-size:.92rem;margin-bottom:14px}
.section-manual p strong{color:var(--text);font-weight:600}

code.inline{
  font-family:'JetBrains Mono',monospace;
  font-size:.85em;
  background:color-mix(in srgb, var(--accent) 12%, transparent);
  color:var(--accent);
  padding:2px 6px;
  border-radius:5px;
  border:1px solid color-mix(in srgb, var(--accent) 22%, transparent);
}
pre{
  background:var(--surface-2);
  border:1px solid var(--border-2);
  color:var(--text);
  padding:16px 18px;
  border-radius:12px;
  overflow-x:auto;
  font-family:'JetBrains Mono',monospace;
  font-size:.82rem;
  line-height:1.65;
  margin-bottom:14px;
}
[data-theme="dark"] pre{background:#05080C;border-color:rgba(255,255,255,.05)}
pre code{background:none;color:inherit;padding:0;font-size:inherit}
.c-cmd{color:var(--success)}
.c-str{color:var(--accent-2)}
.c-cm {color:var(--muted);font-style:italic}
.c-kw {color:#FF7EB6}
.c-var{color:var(--doing)}

table{width:100%;border-collapse:collapse;margin-bottom:14px;font-size:.88rem}
th,td{text-align:left;padding:9px 12px;border-bottom:1px solid var(--border)}
th{
  font-size:.7rem;font-weight:700;letter-spacing:.12em;
  text-transform:uppercase;color:var(--muted);
  border-bottom:2px solid var(--border);
}
td code{font-family:'JetBrains Mono',monospace;font-size:.85em;color:var(--accent)}

.callout{
  display:flex;gap:10px;align-items:flex-start;
  padding:12px 14px;margin:14px 0;
  border-radius:10px;
  background:color-mix(in srgb, var(--doing) 10%, transparent);
  border-left:3px solid var(--doing);
  font-size:.88rem;
  color:var(--text);
}
.callout strong{font-weight:700;color:var(--doing)}

footer{
  text-align:center;
  padding:22px 24px;
  border-top:1px solid var(--border);
  color:var(--muted);
  font-size:.8rem;
}
footer .accent{color:var(--accent)}

@media(max-width:620px){
  main{padding:28px 18px 60px}
  .section-manual{padding:20px 20px}
  pre{padding:12px 14px;font-size:.76rem}
  .back-link span{display:none}
  .toc ul{grid-template-columns:1fr}
}

/* ── Header (partial header-docs.php) ── */
header{position:sticky;top:0;z-index:50;backdrop-filter:blur(20px) saturate(170%);-webkit-backdrop-filter:blur(20px) saturate(170%);background:color-mix(in srgb, var(--bg) 88%, transparent);border-bottom:1px solid var(--border);height:auto;display:block;padding:0;gap:0}
.nav-inner{max-width:1240px;margin:0 auto;padding:0 24px;display:flex;align-items:center;justify-content:space-between;gap:20px;height:72px}
.brand{display:flex;align-items:center;gap:11px;text-decoration:none;color:inherit;min-width:0}
.brand-logo{width:42px;height:42px;border-radius:13px;flex:none;background:linear-gradient(150deg,#FFE0A6,#FFC46B 55%,#F5A623);border:1.5px solid rgba(138,74,0,.35);display:grid;place-items:center;box-shadow:0 8px 20px -10px rgba(224,120,0,.6), inset 0 1px 0 rgba(255,255,255,.7)}
.brand-logo svg{width:28px;height:28px}
.brand-text{display:flex;flex-direction:column}
.brand-name{font-weight:800;font-size:1.2rem;letter-spacing:-.03em;line-height:1.1;color:var(--text)}
.brand-name .accent{color:var(--accent)}
.brand-sub{font-size:.6rem;font-weight:700;letter-spacing:.22em;color:var(--accent);text-transform:uppercase;line-height:1.2}
.nav-links{display:flex;align-items:center;gap:6px;flex:none}
.nav-link{display:inline-flex;align-items:center;gap:8px;padding:9px 14px;border-radius:10px;font-size:.86rem;font-weight:600;color:var(--muted);text-decoration:none;transition:all .2s;border:1px solid transparent}
.nav-link:hover{color:var(--accent);background:color-mix(in srgb, var(--accent) 10%, transparent);border-color:color-mix(in srgb, var(--accent) 22%, transparent)}
.nav-link.active{color:var(--accent);background:color-mix(in srgb, var(--accent) 14%, transparent);border-color:color-mix(in srgb, var(--accent) 30%, transparent)}
.nav-link svg{width:15px;height:15px;flex:none;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
.nav-cta{display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border-radius:100px;font-size:.84rem;font-weight:700;color:#FFFFFF;text-decoration:none;background:linear-gradient(150deg,#FFC46B,#F5A623 50%,#E07800);border:1px solid rgba(138,74,0,.35);box-shadow:0 8px 20px -10px rgba(224,120,0,.85), inset 0 1px 0 rgba(255,255,255,.55);text-shadow:0 1px 2px rgba(120,60,0,.30);transition:all .22s}
.nav-cta:hover{transform:translateY(-1px)}
.nav-cta svg{width:15px;height:15px;stroke:#fff;fill:none;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round}
@media(max-width:720px){.nav-links .nav-link span{display:none}.nav-link{padding:9px}.nav-inner{padding:0 18px}}
</style>
</head>
<body>

<!-- Sprite de ícones (usado pelo partial header-docs.php) -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <defs>
    <linearGradient id="bvg" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="#FFE7BE"/>
      <stop offset="48%" stop-color="#F5A623"/>
      <stop offset="100%" stop-color="#E07800"/>
    </linearGradient>
    <symbol id="beaver" viewBox="0 0 64 64">
      <circle cx="13" cy="17.5" r="7.5" fill="url(#bvg)"/>
      <circle cx="51" cy="17.5" r="7.5" fill="url(#bvg)"/>
      <ellipse cx="32" cy="33" rx="23" ry="21" fill="url(#bvg)"/>
      <ellipse cx="32" cy="41" rx="15.5" ry="12" fill="#8A4A00" opacity=".28"/>
      <ellipse cx="32" cy="34.5" rx="4.6" ry="3.2" fill="#2B1606"/>
      <circle cx="22.5" cy="26" r="3.4" fill="#2B1606"/>
      <circle cx="41.5" cy="26" r="3.4" fill="#2B1606"/>
      <circle cx="23.6" cy="25" r="1.2" fill="#FFFCF6"/>
      <circle cx="42.6" cy="25" r="1.2" fill="#FFFCF6"/>
      <rect x="27.3" y="44.5" width="4.3" height="10.5" rx="1.7" fill="#FFFCF6"/>
      <rect x="32.4" y="44.5" width="4.3" height="10.5" rx="1.7" fill="#FFFCF6"/>
    </symbol>
    <symbol id="ico-home" viewBox="0 0 24 24"><path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/><path d="M9 20v-6h6v6"/></symbol>
    <symbol id="ico-book" viewBox="0 0 24 24"><path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H6.5A2.5 2.5 0 0 0 4 22.5V4.5z"/><path d="M4 4.5A2.5 2.5 0 0 0 6.5 7H20"/></symbol>
    <symbol id="ico-terminal" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 9l3 3-3 3"/><path d="M13 15h4"/></symbol>
    <symbol id="ico-tag" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><circle cx="7" cy="7" r="1.5"/></symbol>
    <symbol id="ico-gh" viewBox="0 0 24 24"><path d="M12 .5C5.7.5.5 5.7.5 12c0 5.1 3.3 9.4 7.9 10.9.6.1.8-.2.8-.6v-2c-3.2.7-3.9-1.5-3.9-1.5-.5-1.3-1.3-1.7-1.3-1.7-1.1-.7.1-.7.1-.7 1.2.1 1.8 1.2 1.8 1.2 1 1.8 2.7 1.3 3.4 1 .1-.8.4-1.3.7-1.6-2.6-.3-5.3-1.3-5.3-5.8 0-1.3.5-2.3 1.2-3.1-.1-.3-.5-1.5.1-3.1 0 0 1-.3 3.3 1.2a11.5 11.5 0 016 0C17.6 4.7 18.6 5 18.6 5c.6 1.6.2 2.8.1 3.1.8.8 1.2 1.8 1.2 3.1 0 4.5-2.7 5.5-5.3 5.8.4.4.8 1.1.8 2.2v3.3c0 .3.2.7.8.6 4.6-1.5 7.9-5.8 7.9-10.9C23.5 5.7 18.3.5 12 .5z"/></symbol>
  </defs>
</svg>

<?php
$active  = 'manual';
$version = $version ?? beaver_version();
require __DIR__ . '/partials/header-docs.php';
?>

<main>

  <h1>Manual do Beaver</h1>
  <p class="lead">
    Guia rápido do <strong>Beaver Framework</strong> — instalação, CLI, rotas, modelos,
    middleware, temas, plugins e muito mais.
    Referência completa em <strong>docs.beaver-framework.dev</strong>.
  </p>

  <!-- Índice visual em cards -->
  <div class="card-grid">
    <a class="card" href="#instalacao">
      <span class="card-icon">⚡</span>
      <span class="card-title">Instalação</span>
      <span class="card-desc">Composer, requisitos e primeiros passos.</span>
    </a>
    <a class="card" href="#cli">
      <span class="card-icon">🖥️</span>
      <span class="card-title">CLI</span>
      <span class="card-desc">Comandos <code class="inline">beaver</code> essenciais.</span>
    </a>
    <a class="card" href="#rotas">
      <span class="card-icon">🛣️</span>
      <span class="card-title">Rotas</span>
      <span class="card-desc">Grupos, middleware e parâmetros dinâmicos.</span>
    </a>
    <a class="card" href="#modelos">
      <span class="card-icon">🗄️</span>
      <span class="card-title">Modelos</span>
      <span class="card-desc">ORM, relações e migrations.</span>
    </a>
    <a class="card" href="#middleware" data-color="blue">
      <span class="card-icon">🛡️</span>
      <span class="card-title">Middleware</span>
      <span class="card-desc">Cadeia de requests, auth e throttling.</span>
    </a>
    <a class="card" href="#temas" data-color="violet">
      <span class="card-icon">🎨</span>
      <span class="card-title">Temas</span>
      <span class="card-desc">SDK de temas, manifests e assets.</span>
    </a>
    <a class="card" href="#plugins" data-color="violet">
      <span class="card-icon">🔌</span>
      <span class="card-title">Plugins</span>
      <span class="card-desc">Estrutura, hooks e ativação.</span>
    </a>
    <a class="card" href="#componentes" data-color="green">
      <span class="card-icon">🧩</span>
      <span class="card-title">Componentes</span>
      <span class="card-desc">Geração com <code class="inline">make:component</code>.</span>
    </a>
    <a class="card" href="#container" data-color="green">
      <span class="card-icon">📦</span>
      <span class="card-title">Container / DI</span>
      <span class="card-desc">Injeção de dependências e bindings.</span>
    </a>
    <a class="card" href="#cache" data-color="blue">
      <span class="card-icon">⚙️</span>
      <span class="card-title">Cache</span>
      <span class="card-desc">Redis, FileCache e TTL.</span>
    </a>
    <a class="card" href="#validacao" data-color="green">
      <span class="card-icon">✅</span>
      <span class="card-title">Validação</span>
      <span class="card-desc">Validation Model e regras declarativas.</span>
    </a>
    <a class="card" href="#eventos">
      <span class="card-icon">📡</span>
      <span class="card-title">Eventos</span>
      <span class="card-desc">Listeners e dispatchers desacoplados.</span>
    </a>
    <a class="card" href="#testes">
      <span class="card-icon">🧪</span>
      <span class="card-title">Testes</span>
      <span class="card-desc">Feature, unit e paralelo.</span>
    </a>
    <a class="card" href="#estrutura">
      <span class="card-icon">📁</span>
      <span class="card-title">Estrutura</span>
      <span class="card-desc">Layout do projeto Beaver.</span>
    </a>
  </div>

  <!-- Índice compacto -->
  <nav class="toc" aria-label="Índice">
    <h2>Índice</h2>
    <ul>
      <li><a href="#instalacao">Instalação</a></li>
      <li><a href="#cli">CLI</a></li>
      <li><a href="#rotas">Rotas</a></li>
      <li><a href="#modelos">Modelos &amp; BD</a></li>
      <li><a href="#middleware">Middleware</a></li>
      <li><a href="#temas">Temas</a></li>
      <li><a href="#plugins">Plugins</a></li>
      <li><a href="#componentes">Componentes</a></li>
      <li><a href="#container">Container / DI</a></li>
      <li><a href="#cache">Cache</a></li>
      <li><a href="#validacao">Validação</a></li>
      <li><a href="#eventos">Eventos</a></li>
      <li><a href="#testes">Testes</a></li>
      <li><a href="#estrutura">Estrutura</a></li>
    </ul>
  </nav>

  <!-- 01 -->
  <section class="section-manual" id="instalacao">
    <h2><span class="section-num">01</span> Instalação</h2>
    <p>Cria um novo projeto Beaver com um único comando:</p>
<pre><code><span class="c-cmd">$</span> composer create-project beaver/app minha-app
<span class="c-cmd">$</span> cd minha-app
<span class="c-cmd">$</span> beaver serve</code></pre>
    <p>O servidor fica disponível em <code class="inline">http://localhost:8000</code>.</p>

    <div class="callout">
      <span>⚡</span>
      <span><strong>Requisitos:</strong> PHP 8.3+, Composer 2.x, extensão <code class="inline">pdo_sqlite</code> ou <code class="inline">pdo_mysql</code>.</span>
    </div>
  </section>

  <!-- 02 -->
  <section class="section-manual" id="cli">
    <h2><span class="section-num">02</span> CLI</h2>
    <p>O <code class="inline">beaver</code> é a ferramenta central:</p>

    <table>
      <thead><tr><th>Comando</th><th>Descrição</th></tr></thead>
      <tbody>
        <tr><td><code>beaver serve</code></td><td>Arranca o servidor local</td></tr>
        <tr><td><code>beaver make:model Produto</code></td><td>Modelo + migration + factory + seeder</td></tr>
        <tr><td><code>beaver make:controller ProdutoController</code></td><td>Controller (<code>--resource</code> para REST)</td></tr>
        <tr><td><code>beaver make:migration create_pedidos_table</code></td><td>Migration vazia</td></tr>
        <tr><td><code>beaver make:component Blog</code></td><td>Componente completo (com <code>--beaverffy</code>)</td></tr>
        <tr><td><code>beaver migrate</code></td><td>Aplica migrações pendentes</td></tr>
        <tr><td><code>beaver migrate --seed</code></td><td>Migra + corre seeders</td></tr>
        <tr><td><code>beaver db:seed</code></td><td>Corre seeders</td></tr>
        <tr><td><code>beaver test</code></td><td>Corre os testes</td></tr>
      </tbody>
    </table>
  </section>

  <!-- 03 -->
  <section class="section-manual" id="rotas">
    <h2><span class="section-num">03</span> Rotas</h2>
    <p>Define rotas em <code class="inline">routes/web.php</code>:</p>
<pre><code><span class="c-kw">use</span> <span class="c-var">Beaver\Routing\Route</span>;

<span class="c-var">Route</span>::<span class="c-cmd">get</span>(<span class="c-str">'/'</span>, <span class="c-kw">fn</span>() =&gt; view(<span class="c-str">'home'</span>));
<span class="c-var">Route</span>::<span class="c-cmd">post</span>(<span class="c-str">'/produtos'</span>, [ProdutoController::class, <span class="c-str">'store'</span>]);

<span class="c-var">Route</span>::<span class="c-cmd">group</span>([<span class="c-str">'prefix'</span> =&gt; <span class="c-str">'admin'</span>, <span class="c-str">'middleware'</span> =&gt; <span class="c-str">'auth'</span>], <span class="c-kw">function</span> () {
    <span class="c-var">Route</span>::<span class="c-cmd">get</span>(<span class="c-str">'/dashboard'</span>, [AdminController::class, <span class="c-str">'index'</span>]);
});</code></pre>
  </section>

  <!-- 04 -->
  <section class="section-manual" id="modelos">
    <h2><span class="section-num">04</span> Modelos &amp; BD</h2>
    <p>Um modelo Beaver herda de <code class="inline">Beaver\Database\Model</code>:</p>
<pre><code><span class="c-kw">namespace</span> <span class="c-var">App\Models</span>;

<span class="c-kw">use</span> <span class="c-var">Beaver\Database\Model</span>;

<span class="c-kw">class</span> Produto <span class="c-kw">extends</span> Model
{
    <span class="c-kw">protected array</span> <span class="c-var">$fillable</span> = [<span class="c-str">'nome'</span>, <span class="c-str">'preco'</span>, <span class="c-str">'stock'</span>];

    <span class="c-kw">public function</span> <span class="c-cmd">categoria</span>()
    {
        <span class="c-kw">return</span> <span class="c-var">$this</span>-&gt;belongsTo(Categoria::class);
    }
}</code></pre>
    <p>Consultas rápidas: <code class="inline">Produto::all()</code>, <code class="inline">Produto::where('preco', '&lt;', 50)-&gt;get()</code>, <code class="inline">Produto::ativos()-&gt;paginado(15)</code>.</p>
  </section>

  <!-- 05 -->
  <section class="section-manual" id="middleware">
    <h2><span class="section-num">05</span> Middleware</h2>
    <p>Cria um middleware com um comando:</p>
<pre><code><span class="c-cmd">$</span> beaver make:middleware AuthMiddleware</code></pre>

    <p>O ficheiro fica em <code class="inline">app/Middleware/AuthMiddleware.php</code>:</p>
<pre><code><span class="c-kw">namespace</span> <span class="c-var">App\Middleware</span>;

<span class="c-kw">class</span> AuthMiddleware
{
    <span class="c-kw">public function</span> <span class="c-cmd">handle</span>(<span class="c-var">$request</span>, <span class="c-var">$next</span>)
    {
        <span class="c-kw">if</span> (!auth()-&gt;check()) {
            <span class="c-kw">return</span> redirect(<span class="c-str">'/login'</span>);
        }
        <span class="c-kw">return</span> <span class="c-var">$next</span>(<span class="c-var">$request</span>);
    }
}</code></pre>

    <p>Aplica middleware a rotas ou grupos:</p>
<pre><code><span class="c-var">Route</span>::<span class="c-cmd">get</span>(<span class="c-str">'/admin'</span>, AdminController::class)
    -&gt;<span class="c-cmd">middleware</span>(AuthMiddleware::class);

<span class="c-var">Route</span>::<span class="c-cmd">group</span>([<span class="c-str">'middleware'</span> =&gt; [AuthMiddleware::class]], <span class="c-kw">function</span> () {
    <span class="c-var">Route</span>::<span class="c-cmd">get</span>(<span class="c-str">'/perfil'</span>, <span class="c-kw">fn</span>() =&gt; view(<span class="c-str">'perfil'</span>));
});</code></pre>

    <div class="callout">
      <span>🛡️</span>
      <span>Middlewares correm <strong>em cadeia</strong>, na ordem em que são declarados. O primeiro pode bloquear o pedido antes de chegar ao controller.</span>
    </div>
  </section>

  <!-- 06 -->
  <section class="section-manual" id="temas">
    <h2><span class="section-num">06</span> Temas (Theme SDK)</h2>
    <p>Os temas vivem em <code class="inline">themes/{slug}/</code> e seguem a mesma estrutura dos plugins:</p>
<pre><code>themes/meu-tema/
├── theme.schema.json      <span class="c-cm"># manifesto</span>
├── config.php             <span class="c-cm"># configuração do tema</span>
└── resources/
    ├── views/             <span class="c-cm"># templates</span>
    └── ui/                <span class="c-cm"># assets (css, js, img)</span></code></pre>

    <h3>Ativar um tema</h3>
<pre><code><span class="c-cmd">$</span> beaver theme:activate meu-tema</code></pre>

    <h3>Resolver paths programaticamente</h3>
<pre><code><span class="c-var">$mgr</span> = app()-&gt;<span class="c-cmd">make</span>(<span class="c-var">ThemeManager</span>::class);
<span class="c-var">$dir</span> = <span class="c-var">$mgr</span>-&gt;<span class="c-cmd">path</span>(<span class="c-str">'meu-tema'</span>);</code></pre>

    <h3>Servir assets</h3>
    <p>Assets são servidos em <code class="inline">/themes/{slug}/{kind}/{file}</code>:</p>
<pre><code>&lt;link rel=<span class="c-str">"stylesheet"</span> href=<span class="c-str">"/themes/meu-tema/css/style.css"</span>&gt;
&lt;script src=<span class="c-str">"/themes/meu-tema/js/app.js"</span>&gt;&lt;/script&gt;</code></pre>

    <div class="callout">
      <span>🎨</span>
      <span><strong>Fallback automático:</strong> o <code class="inline">View::resolve()</code> procura primeiro no tema ativo; se não encontrar, cai para <code class="inline">app/views/</code>.</span>
    </div>
  </section>

  <!-- 07 -->
  <section class="section-manual" id="plugins">
    <h2><span class="section-num">07</span> Plugins</h2>
    <p>Os plugins seguem uma estrutura convencional, semelhante à dos temas:</p>
<pre><code>plugins/meu-plugin/
├── plugin.schema.json     <span class="c-cm"># manifesto</span>
├── Plugin.php             <span class="c-cm"># classe principal</span>
├── resources/
│   ├── views/
│   └── ui/
└── routes.php             <span class="c-cm"># rotas do plugin</span></code></pre>

    <h3>Manifesto (<code class="inline">plugin.schema.json</code>)</h3>
<pre><code>{
  <span class="c-str">"name"</span>: <span class="c-str">"Meu Plugin"</span>,
  <span class="c-str">"slug"</span>: <span class="c-str">"meu-plugin"</span>,
  <span class="c-str">"version"</span>: <span class="c-str">"1.0.0"</span>,
  <span class="c-str">"author"</span>: <span class="c-str">"José Franco"</span>,
  <span class="c-str">"requires"</span>: { <span class="c-str">"beaver"</span>: <span class="c-str">"^1.4"</span> }
}</code></pre>

    <h3>Ativar / desativar</h3>
<pre><code><span class="c-cmd">$</span> beaver plugin:activate meu-plugin
<span class="c-cmd">$</span> beaver plugin:deactivate meu-plugin</code></pre>
  </section>

  <!-- 08 -->
  <section class="section-manual" id="componentes">
    <h2><span class="section-num">08</span> Componentes</h2>
    <p>Cria componentes completos com um comando:</p>
<pre><code><span class="c-cmd">$</span> beaver make:component Blog
<span class="c-cmd">$</span> beaver make:component Blog --beaverffy</code></pre>

    <p>O flag <code class="inline">--beaverffy</code> gera também um template responsivo de exemplo, pronto a usar.</p>

    <h3>O que é gerado</h3>
    <table>
      <thead><tr><th>Ficheiro</th><th>Descrição</th></tr></thead>
      <tbody>
        <tr><td><code>app/Models/Blog.php</code></td><td>Modelo</td></tr>
        <tr><td><code>app/Controllers/BlogController.php</code></td><td>Controller resource</td></tr>
        <tr><td><code>database/migrations/..._create_blogs_table.php</code></td><td>Migration</td></tr>
        <tr><td><code>database/seeders/BlogSeeder.php</code></td><td>Seeder</td></tr>
        <tr><td><code>resources/views/blog/index.php</code></td><td>View principal</td></tr>
        <tr><td><code>routes/blog.php</code></td><td>Rotas do componente</td></tr>
      </tbody>
    </table>

    <div class="callout">
      <span>🧩</span>
      <span>O terminal do Beaver está atualmente <strong>em português</strong>. Uma opção de idioma (inglês) está planeada para futuras versões.</span>
    </div>
  </section>

  <!-- 09 -->
  <section class="section-manual" id="container">
    <h2><span class="section-num">09</span> Container / DI</h2>
    <p>O container resolve dependências automaticamente (autowiring):</p>
<pre><code><span class="c-cm">// registar um binding</span>
app()-&gt;<span class="c-cmd">bind</span>(<span class="c-var">Logger::class</span>, <span class="c-kw">function</span> () {
    <span class="c-kw">return new</span> <span class="c-var">FileLogger</span>(<span class="c-str">'storage/logs/app.log'</span>);
});

<span class="c-cm">// resolver</span>
<span class="c-var">$logger</span> = app()-&gt;<span class="c-cmd">make</span>(<span class="c-var">Logger::class</span>);</code></pre>

    <p>Injeção em controllers por tipo:</p>
<pre><code><span class="c-kw">class</span> ProdutoController
{
    <span class="c-kw">public function</span> <span class="c-cmd">__construct</span>(<span class="c-kw">private</span> <span class="c-var">Logger</span> <span class="c-var">$logger</span>) {}

    <span class="c-kw">public function</span> <span class="c-cmd">index</span>()
    {
        <span class="c-var">$this</span>-&gt;logger-&gt;<span class="c-cmd">info</span>(<span class="c-str">'Listando produtos'</span>);
    }
}</code></pre>
  </section>

  <!-- 10 -->
  <section class="section-manual" id="cache">
    <h2><span class="section-num">10</span> Cache</h2>
    <p>Dois drivers prontos: <code class="inline">file</code> e <code class="inline">redis</code>.</p>
<pre><code><span class="c-cm">// guardar 1 hora</span>
cache()-&gt;<span class="c-cmd">set</span>(<span class="c-str">'produtos'</span>, <span class="c-var">$lista</span>, 3600);

<span class="c-cm">// ler com fallback</span>
<span class="c-var">$produtos</span> = cache()-&gt;<span class="c-cmd">remember</span>(<span class="c-str">'produtos'</span>, 3600, <span class="c-kw">function</span> () {
    <span class="c-kw">return</span> <span class="c-var">Produto</span>::<span class="c-cmd">all</span>();
});</code></pre>

    <p>Configuração em <code class="inline">.env</code>:</p>
<pre><code>CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379</code></pre>
  </section>

  <!-- 11 -->
  <section class="section-manual" id="validacao">
    <h2><span class="section-num">11</span> Validação</h2>
    <p>O <strong>Validation Model</strong> é injetado no modelo atual e define regras declarativamente:</p>
<pre><code><span class="c-kw">class</span> Produto <span class="c-kw">extends</span> Model
{
    <span class="c-kw">protected array</span> <span class="c-var">$rules</span> = [
        <span class="c-str">'nome'</span>  =&gt; <span class="c-str">'required|min:3|max:120'</span>,
        <span class="c-str">'preco'</span> =&gt; <span class="c-str">'required|numeric|min:0'</span>,
        <span class="c-str">'stock'</span> =&gt; <span class="c-str">'integer|min:0'</span>,
    ];
}</code></pre>

    <p>Validar antes de guardar:</p>
<pre><code><span class="c-var">$produto</span> = <span class="c-kw">new</span> <span class="c-var">Produto</span>(<span class="c-var">$dados</span>);
<span class="c-kw">if</span> (!<span class="c-var">$produto</span>-&gt;<span class="c-cmd">validate</span>()) {
    <span class="c-kw">return</span> response()-&gt;<span class="c-cmd">json</span>(<span class="c-var">$produto</span>-&gt;<span class="c-cmd">errors</span>(), 422);
}
<span class="c-var">$produto</span>-&gt;<span class="c-cmd">save</span>();</code></pre>
  </section>

  <!-- 12 -->
  <section class="section-manual" id="eventos">
    <h2><span class="section-num">12</span> Eventos</h2>
    <p>Eventos desacoplam a lógica entre partes do sistema:</p>
<pre><code><span class="c-cm">// registar listener</span>
event()-&gt;<span class="c-cmd">on</span>(<span class="c-var">ProdutoCriado</span>::class, <span class="c-kw">function</span> (<span class="c-var">$evento</span>) {
    mail()-&gt;<span class="c-cmd">send</span>(<span class="c-str">'admin@loja.pt'</span>, <span class="c-str">'Novo produto'</span>, <span class="c-var">$evento</span>-&gt;produto-&gt;nome);
});

<span class="c-cm">// disparar</span>
event()-&gt;<span class="c-cmd">dispatch</span>(<span class="c-kw">new</span> <span class="c-var">ProdutoCriado</span>(<span class="c-var">$produto</span>));</code></pre>
  </section>

  <!-- 13 -->
  <section class="section-manual" id="testes">
    <h2><span class="section-num">13</span> Testes</h2>
    <p>Os testes vivem em <code class="inline">tests/</code>:</p>
<pre><code><span class="c-cmd">$</span> beaver test
<span class="c-cmd">$</span> beaver test --parallel
<span class="c-cmd">$</span> beaver test --filter=ProdutoTest</code></pre>
  </section>

  <!-- 14 -->
  <section class="section-manual" id="estrutura">
    <h2><span class="section-num">14</span> Estrutura do projeto</h2>
<pre><code>minha-app/
├── app/
│   ├── Controllers/
│   ├── Models/
│   ├── Middleware/
│   └── Requests/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── plugins/          <span class="c-cm"># plugins instalados</span>
├── themes/           <span class="c-cm"># temas instalados</span>
├── public/
│   └── index.php
├── resources/
│   └── views/
├── routes/
│   └── web.php
├── tests/
├── .env
└── composer.json</code></pre>
  </section>

</main>

<footer>
  Beaver Framework · feito com <span class="accent">🦫</span> · <span id="year"></span>
</footer>

<script>
(function () {
  'use strict';

  var root = document.documentElement;
  var stored = localStorage.getItem('beaver-progress-theme');
  if (stored === 'dark' || stored === 'light') {
    root.setAttribute('data-theme', stored);
  } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    root.setAttribute('data-theme', 'dark');
  }

  var toggle = document.getElementById('theme-toggle');
  if (toggle) {
    toggle.addEventListener('click', function () {
      var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      root.setAttribute('data-theme', next);
      localStorage.setItem('beaver-progress-theme', next);
    });
  }

  var year = document.getElementById('year');
  if (year) year.textContent = new Date().getFullYear();
})();
</script>
</body>
</html>
