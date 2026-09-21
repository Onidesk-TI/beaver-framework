<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Marketplace · Beaver SqlWizard</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<style>
  *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}

  :root{
    /* ── Fundos — light theme (como index) ── */
    --bg:#FBF9F4;
    --bg-2:#F5F1EA;
    --surface:#FFFFFF;
    --surface-2:#F5F1EA;

    /* ── Texto ── */
    --text:#1A202C;
    --muted:#6B7280;
    --soft:#94A3B8;

    /* ── Âmbar ── */
    --amber:#F59E0B;
    --amber-2:#EA580C;
    --amber-3:#FBBF24;
    --amber-soft:#FEF3C7;

    /* ── Apoio ── */
    --green:#16A34A;
    --violet:#7C6CE0;
    --blue:#3B82F6;
    --red:#DC2626;

    /* ── Linhas ── */
    --line:rgba(15,23,42,.08);
    --line-strong:rgba(15,23,42,.14);

    /* ── Sombras ── */
    --shadow-sm:0 1px 2px rgba(15,23,42,.06);
    --shadow-md:0 4px 12px -2px rgba(15,23,42,.08), 0 2px 4px -2px rgba(15,23,42,.05);
    --shadow-lg:0 20px 40px -20px rgba(15,23,42,.18), 0 8px 20px -12px rgba(15,23,42,.1);

    --radius-sm:6px;
    --radius:10px;
    --radius-lg:14px;
    --radius-xl:20px;

    --t-fast:.15s cubic-bezier(.4,0,.2,1);
    --t:.25s cubic-bezier(.4,0,.2,1);

    --font-mono:'JetBrains Mono','Fira Code',monospace;
  }

  html,body{height:100%}

  body{
    font-family:'Inter',system-ui,-apple-system,sans-serif;
    background:var(--bg);
    color:var(--text);
    line-height:1.55;
    -webkit-font-smoothing:antialiased;
    overflow-x:hidden;
    min-height:100vh;
    display:flex;
    flex-direction:column;
    font-size:14px;
  }

  body::before{
    content:"";position:fixed;inset:0;z-index:-2;pointer-events:none;
    background:
      radial-gradient(900px 500px at 12% -8%, rgba(251,191,36,.18), transparent 62%),
      radial-gradient(760px 460px at 88% 4%, rgba(124,108,224,.08), transparent 60%),
      radial-gradient(700px 500px at 50% 110%, rgba(234,88,12,.06), transparent 65%);
  }
  body::after{
    content:"";position:fixed;inset:0;z-index:-1;pointer-events:none;
    background-image:
      linear-gradient(rgba(15,23,42,.03) 1px,transparent 1px),
      linear-gradient(90deg,rgba(15,23,42,.03) 1px,transparent 1px);
    background-size:56px 56px;
    mask-image:radial-gradient(ellipse 90% 60% at 50% 0%,#000 20%,transparent 75%);
    -webkit-mask-image:radial-gradient(ellipse 90% 60% at 50% 0%,#000 20%,transparent 75%);
  }

  a{color:inherit;text-decoration:none}
  button{font-family:inherit;cursor:pointer;border:none;background:none;color:inherit}
  img,svg{display:block;max-width:100%}
  ::selection{background:rgba(251,191,36,.4)}

  /* ─── TOPO ─── */
  .topbar{
    position:sticky;top:0;z-index:100;
    background:rgba(251,249,244,.85);
    backdrop-filter:blur(18px) saturate(160%);
    -webkit-backdrop-filter:blur(18px) saturate(160%);
    border-bottom:1px solid var(--line);
  }
  .topbar-inner{
    max-width:1400px;margin:0 auto;padding:0 24px;
    height:60px;display:flex;align-items:center;gap:32px;
  }
  .brand{display:flex;align-items:center;gap:10px;font-weight:700;letter-spacing:-.02em;flex-shrink:0}
  .brand-logo{
    width:34px;height:34px;border-radius:9px;
    background:linear-gradient(145deg,rgba(251,191,36,.28),rgba(234,88,12,.08));
    border:1px solid rgba(234,88,12,.22);
    display:grid;place-items:center;font-size:17px;
    box-shadow:0 6px 16px -8px rgba(234,88,12,.5);
    transition:transform .3s;
  }
  .brand:hover .brand-logo{transform:rotate(-8deg) scale(1.06)}
  .brand-name{font-size:15px;color:var(--text)}
  .brand-name .accent{color:var(--amber-2)}

  .main-nav{display:flex;align-items:center;gap:4px;margin-left:8px}
  .main-nav a{
    padding:7px 12px;font-size:13px;font-weight:500;
    color:var(--muted);border-radius:var(--radius-sm);transition:all var(--t-fast);
  }
  .main-nav a:hover{color:var(--text);background:rgba(15,23,42,.05)}
  .main-nav a.is-active{color:var(--amber-2);background:var(--amber-soft)}

  .topbar-actions{margin-left:auto;display:flex;align-items:center;gap:8px}

  .btn{
    display:inline-flex;align-items:center;justify-content:center;gap:6px;
    padding:8px 16px;font-size:13px;font-weight:600;
    border-radius:var(--radius-sm);border:1px solid transparent;
    transition:all var(--t-fast);white-space:nowrap;letter-spacing:-.005em;cursor:pointer;
  }
  .btn-ghost{
    color:var(--text);background:var(--surface);border-color:var(--line-strong);
    box-shadow:var(--shadow-sm);
  }
  .btn-ghost:hover{background:var(--surface-2);box-shadow:var(--shadow-md);transform:translateY(-1px)}

  .btn-primary{
    color:#fff;
    background:linear-gradient(135deg,var(--amber) 0%,var(--amber-2) 100%);
    box-shadow:0 10px 22px -10px rgba(234,88,12,.6), 0 2px 4px rgba(234,88,12,.15);
  }
  .btn-primary:hover{
    transform:translateY(-1px);
    box-shadow:0 14px 26px -10px rgba(234,88,12,.7), 0 4px 8px rgba(234,88,12,.2);
  }

  /* ─── BARRA DE FILTROS ─── */
  .filters-bar{
    background:var(--bg-2);
    border-bottom:1px solid var(--line);
    padding:0;height:40px;display:flex;align-items:center;
    overflow-x:auto;overflow-y:hidden;scrollbar-width:none;
  }
  .filters-bar::-webkit-scrollbar{display:none}
  .filters-inner{
    max-width:1400px;margin:0 auto;padding:0 24px;
    display:flex;align-items:center;gap:6px;
    width:100%;height:100%;min-width:max-content;
  }
  .filter-label{
    font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.08em;
    color:var(--soft);margin-right:8px;flex-shrink:0;
  }
  .chip{
    display:inline-flex;align-items:center;gap:6px;
    padding:5px 11px;font-size:12px;font-weight:500;
    color:var(--muted);background:var(--surface);
    border:1px solid var(--line);border-radius:100px;height:26px;flex-shrink:0;
    transition:all var(--t-fast);cursor:pointer;box-shadow:var(--shadow-sm);
  }
  .chip:hover{color:var(--text);border-color:var(--line-strong);background:var(--surface-2)}
  .chip.is-active{
    color:#fff;
    background:linear-gradient(135deg,var(--amber),var(--amber-2));
    border-color:transparent;font-weight:700;
    box-shadow:0 4px 10px -4px rgba(234,88,12,.5);
  }
  .chip .dot{width:5px;height:5px;border-radius:50%;background:currentColor;opacity:.7}
  .chip.is-active .dot{opacity:1;background:#fff}

  .filters-spacer{flex:1;min-width:20px}

  .filters-search{
    display:flex;align-items:center;gap:6px;
    padding:4px 12px 4px 10px;background:var(--surface);
    border:1px solid var(--line);border-radius:100px;height:28px;flex-shrink:0;
    transition:all var(--t-fast);box-shadow:var(--shadow-sm);
  }
  .filters-search:focus-within{
    border-color:rgba(234,88,12,.4);
    box-shadow:0 0 0 3px rgba(251,191,36,.2), var(--shadow-sm);
  }
  .filters-search svg{width:12px;height:12px;stroke:var(--soft);fill:none;stroke-width:2}
  .filters-search input{
    background:transparent;border:none;outline:none;
    color:var(--text);font-size:12px;font-family:inherit;width:160px;
  }
  .filters-search input::placeholder{color:var(--soft)}

  /* ─── CABEÇALHO ─── */
  .page-head{max-width:1400px;margin:0 auto;padding:32px 24px 8px;width:100%}
  .page-title{
    font-size:26px;font-weight:800;letter-spacing:-.035em;
    line-height:1.15;margin-bottom:6px;color:var(--text);
  }
  .page-title .accent{
    background:linear-gradient(120deg,var(--amber-3) 0%,var(--amber) 45%,var(--amber-2) 85%);
    -webkit-background-clip:text;background-clip:text;color:transparent;
  }
  .page-subtitle{font-size:13.5px;color:var(--muted);max-width:560px}
  .page-meta{display:flex;gap:18px;margin-top:14px;font-size:12px;color:var(--soft)}
  .page-meta b{color:var(--text);font-weight:600}

  /* ─── GRELHA ─── */
  .grid-wrap{max-width:1400px;margin:0 auto;padding:20px 24px 60px;width:100%;flex:1}
  .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:16px}

  .plugin-card{
    background:var(--surface);
    border:1px solid var(--line-strong);
    border-radius:var(--radius-lg);padding:20px;
    display:flex;flex-direction:column;gap:14px;
    transition:all var(--t);position:relative;overflow:hidden;
    box-shadow:var(--shadow-sm);
  }
  .plugin-card::before{
    content:"";position:absolute;top:0;left:20px;right:20px;height:1px;
    background:linear-gradient(90deg,transparent,rgba(234,88,12,.3),transparent);
    opacity:.5;transition:opacity var(--t);
  }
  .plugin-card:hover{
    border-color:rgba(234,88,12,.28);
    transform:translateY(-3px);
    box-shadow:var(--shadow-lg), 0 0 0 1px rgba(234,88,12,.06);
  }
  .plugin-card:hover::before{opacity:1}

  .card-head{display:flex;align-items:flex-start;gap:12px}
  .card-icon{
    width:44px;height:44px;border-radius:11px;
    display:grid;place-items:center;font-size:20px;flex-shrink:0;
    background:linear-gradient(145deg,rgba(251,191,36,.22),rgba(234,88,12,.06));
    border:1px solid rgba(234,88,12,.2);
    box-shadow:0 4px 10px -6px rgba(234,88,12,.3);
  }
  .card-icon.amber{background:linear-gradient(145deg,rgba(251,191,36,.22),rgba(234,88,12,.06));border-color:rgba(234,88,12,.2)}
  .card-icon.violet{background:linear-gradient(145deg,rgba(124,108,224,.18),rgba(124,108,224,.05));border-color:rgba(124,108,224,.24)}
  .card-icon.green{background:linear-gradient(145deg,rgba(22,163,74,.18),rgba(22,163,74,.05));border-color:rgba(22,163,74,.24)}
  .card-icon.blue{background:linear-gradient(145deg,rgba(59,130,246,.18),rgba(59,130,246,.05));border-color:rgba(59,130,246,.24)}
  .card-icon.red{background:linear-gradient(145deg,rgba(220,38,38,.16),rgba(220,38,38,.04));border-color:rgba(220,38,38,.22)}

  .card-titles{flex:1;min-width:0}
  .card-title{
    font-size:15px;font-weight:700;letter-spacing:-.02em;
    margin-bottom:2px;display:flex;align-items:center;gap:6px;line-height:1.25;
    color:var(--text);
  }
  .card-author{font-size:12px;color:var(--muted);display:flex;align-items:center;gap:5px}
  .card-author b{color:var(--text);font-weight:600}
  .card-author .sep{opacity:.5}

  .card-badges{display:flex;gap:6px;flex-wrap:wrap}
  .badge{
    display:inline-flex;align-items:center;gap:4px;
    padding:3px 8px;font-size:10.5px;font-weight:600;
    letter-spacing:.02em;text-transform:uppercase;
    border-radius:5px;border:1px solid transparent;white-space:nowrap;
  }
  .badge-category{color:var(--blue);background:rgba(59,130,246,.08);border-color:rgba(59,130,246,.22)}
  .badge-category.cat-db{color:#B45309;background:var(--amber-soft);border-color:rgba(234,88,12,.22)}
  .badge-category.cat-ui{color:var(--violet);background:rgba(124,108,224,.08);border-color:rgba(124,108,224,.22)}
  .badge-category.cat-auth{color:var(--green);background:rgba(22,163,74,.08);border-color:rgba(22,163,74,.22)}

  .badge-free{color:var(--green);background:rgba(22,163,74,.1);border-color:rgba(22,163,74,.24)}
  .badge-paid{color:#B45309;background:var(--amber-soft);border-color:rgba(234,88,12,.24)}

  .card-desc{
    font-size:13px;color:var(--muted);line-height:1.55;
    display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;
    overflow:hidden;min-height:40px;
  }

  .card-foot{
    display:flex;align-items:center;justify-content:space-between;gap:10px;
    padding-top:12px;border-top:1px solid var(--line);margin-top:auto;
  }
  .card-price{display:flex;align-items:baseline;gap:5px;font-family:var(--font-mono)}
  .card-price .amount{font-size:16px;font-weight:700;color:var(--text);letter-spacing:-.02em}
  .card-price .amount.gratis{color:var(--green);font-size:13px;text-transform:uppercase;letter-spacing:.05em}
  .card-price .period{font-size:10.5px;color:var(--soft)}

  .card-cta{
    display:inline-flex;align-items:center;gap:5px;
    padding:7px 13px;font-size:12px;font-weight:600;
    border-radius:var(--radius-sm);
    background:var(--surface);
    border:1px solid var(--line-strong);
    color:var(--text);transition:all var(--t-fast);white-space:nowrap;
    box-shadow:var(--shadow-sm);
  }
  .card-cta:hover{
    background:linear-gradient(135deg,var(--amber),var(--amber-2));
    border-color:transparent;color:#fff;
    transform:translateY(-1px);
    box-shadow:0 8px 16px -8px rgba(234,88,12,.6);
  }
  .card-cta svg{width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2.5}

  /* ─── RODAPÉ ─── */
  footer{
    border-top:1px solid var(--line);
    background:rgba(245,241,234,.6);
    padding:22px 24px;text-align:center;font-size:12px;color:var(--muted);
  }
  footer .accent{color:var(--amber-2)}
  footer b{color:var(--text);font-weight:600}

  /* ─── RESPONSIVO ─── */
  @media(max-width:900px){
    .main-nav{display:none}
    .topbar-inner{gap:16px}
  }
  @media(max-width:620px){
    .topbar-inner{padding:0 16px;height:56px}
    .brand-name{display:none}
    .filters-inner{padding:0 16px}
    .filters-search input{width:100px}
    .page-head{padding:24px 16px 8px}
    .page-title{font-size:22px}
    .grid-wrap{padding:16px 16px 40px}
    .grid{grid-template-columns:1fr;gap:12px}
    .btn-ghost{display:none}
  }
</style>
</head>
<body>

<header class="topbar">
  <div class="topbar-inner">
    <a href="/" class="brand">
      <span class="brand-logo">🦫</span>
      <span class="brand-name">Beaver<span class="accent">·</span>Marketplace</span>
    </a>
    <nav class="main-nav">
      <a href="/sqlwizard">SqlWizard</a>
      <a href="#" class="is-active">Marketplace</a>
      <a href="#">Docs</a>
      <a href="#">Comunidade</a>
    </nav>
    <div class="topbar-actions">
      <a href="#" class="btn btn-ghost">Entrar</a>
      <a href="#" class="btn btn-primary">Criar conta</a>
    </div>
  </div>
</header>

<div class="filters-bar">
  <div class="filters-inner">
    <span class="filter-label">Filtrar</span>
    <button class="chip is-active"><span class="dot"></span>Todos</button>
    <button class="chip"><span class="dot"></span>Grátis</button>
    <button class="chip"><span class="dot"></span>Pagos</button>
    <button class="chip">Base de dados</button>
    <button class="chip">UI / Tema</button>
    <button class="chip">Autenticação</button>
    <button class="chip">Faturação</button>
    <button class="chip">Ferramentas</button>
    <span class="filters-spacer"></span>
    <div class="filters-search">
      <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/></svg>
      <input type="text" placeholder="Procurar plugins…">
    </div>
  </div>
</div>

<div class="page-head">
  <h1 class="page-title">Plugins da <span class="accent">comunidade</span></h1>
  <p class="page-subtitle">Extensões oficiais e contribuições da comunidade para o SqlWizard. Instala em segundos, sem sair do Beaver.</p>
  <div class="page-meta">
    <span><b>24</b> plugins disponíveis</span>
    <span><b>14</b> gratuitos</span>
    <span><b>10</b> pagos</span>
  </div>
</div>

<div class="grid-wrap">
  <div class="grid">

    <article class="plugin-card">
      <div class="card-head">
        <div class="card-icon amber">🗄️</div>
        <div class="card-titles">
          <div class="card-title">SqlAnalyser</div>
          <div class="card-author">por <b>Beaver Team</b> <span class="sep">·</span> <span>v2.1.0</span></div>
        </div>
      </div>
      <div class="card-badges">
        <span class="badge badge-category cat-db">Base de dados</span>
        <span class="badge badge-free">Grátis</span>
      </div>
      <p class="card-desc">Analise, otimize e monitorize as suas queries em tempo real. Deteção N+1, planos de execução visuais e sugestões de índices.</p>
      <div class="card-foot">
        <div class="card-price"><span class="amount gratis">Grátis</span></div>
        <div class="card-actions"><a href="/marketplace/p/sqlanalyser" class="card-cta">Ver projeto <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17L17 7M17 7H9M17 7v8"/></svg></a><a href="https://github.com/beaver-framework/sqlanalyser" target="_blank" rel="noopener" class="card-cta card-cta-dl">Download <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12M7 10l5 5 5-5M5 21h14"/></svg></a></div>
      </div>
    </article>

    <article class="plugin-card">
      <div class="card-head">
        <div class="card-icon green">🔑</div>
        <div class="card-titles">
          <div class="card-title">Frankey</div>
          <div class="card-author">por <b>Beaver Team</b> <span class="sep">·</span> <span>v1.8.2</span></div>
        </div>
      </div>
      <div class="card-badges">
        <span class="badge badge-category cat-auth">Autenticação</span>
        <span class="badge badge-free">Grátis</span>
      </div>
      <p class="card-desc">Autenticação, autorização, licenciamento e gestão de chaves numa só biblioteca. JWT, 2FA, RBAC e API keys.</p>
      <div class="card-foot">
        <div class="card-price"><span class="amount gratis">Grátis</span></div>
        <div class="card-actions"><a href="/marketplace/p/frankey" class="card-cta">Ver projeto <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17L17 7M17 7H9M17 7v8"/></svg></a><a href="https://github.com/beaver-framework/frankey" target="_blank" rel="noopener" class="card-cta card-cta-dl">Download <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12M7 10l5 5 5-5M5 21h14"/></svg></a></div>
      </div>
    </article>

    <article class="plugin-card">
      <div class="card-head">
        <div class="card-icon amber">⚡</div>
        <div class="card-titles">
          <div class="card-title">Query Optimizer Pro</div>
          <div class="card-author">por <b>Onidesk Labs</b> <span class="sep">·</span> <span>v3.0.1</span></div>
        </div>
      </div>
      <div class="card-badges">
        <span class="badge badge-category cat-db">Base de dados</span>
        <span class="badge badge-paid">Pago</span>
      </div>
      <p class="card-desc">Sugestões automáticas de índices, reescrita inteligente de queries e benchmarks A/B. Reduz a latência em até 80%.</p>
      <div class="card-foot">
        <div class="card-price"><span class="amount">€19</span><span class="period">/mês</span></div>
        <div class="card-actions"><a href="/marketplace/p/query-optimizer-pro" class="card-cta">Ver projeto <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17L17 7M17 7H9M17 7v8"/></svg></a><a href="#" class="card-cta card-cta-buy">Comprar <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a></div>
      </div>
    </article>

    <article class="plugin-card">
      <div class="card-head">
        <div class="card-icon violet">🎨</div>
        <div class="card-titles">
          <div class="card-title">Dark UI Theme</div>
          <div class="card-author">por <b>Ana Ribeiro</b> <span class="sep">·</span> <span>v1.0.4</span></div>
        </div>
      </div>
      <div class="card-badges">
        <span class="badge badge-category cat-ui">UI / Tema</span>
        <span class="badge badge-free">Grátis</span>
      </div>
      <p class="card-desc">Tema escuro de alto contraste para o painel do SqlWizard. Tipografia otimizada, cores acessíveis WCAG AA.</p>
      <div class="card-foot">
        <div class="card-price"><span class="amount gratis">Grátis</span></div>
        <a href="#" class="card-cta">Ver projeto <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17L17 7M17 7H9M17 7v8"/></svg></a>
      </div>
    </article>

    <article class="plugin-card">
      <div class="card-head">
        <div class="card-icon blue">💳</div>
        <div class="card-titles">
          <div class="card-title">SIBS MB WAY Bridge</div>
          <div class="card-author">por <b>Onidesk Labs</b> <span class="sep">·</span> <span>v2.4.0</span></div>
        </div>
      </div>
      <div class="card-badges">
        <span class="badge badge-category">Faturação</span>
        <span class="badge badge-paid">Pago</span>
      </div>
      <p class="card-desc">Integração nativa com SIBS MB WAY para pagamentos em Portugal. Checkout, status e webhooks prontos a usar.</p>
      <div class="card-foot">
        <div class="card-price"><span class="amount">€49</span><span class="period">pagamento único</span></div>
        <div class="card-actions"><a href="/marketplace/p/sibs-mb-way-bridge" class="card-cta">Ver projeto <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17L17 7M17 7H9M17 7v8"/></svg></a><a href="#" class="card-cta card-cta-buy">Comprar <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a></div>
      </div>
    </article>

    <article class="plugin-card">
      <div class="card-head">
        <div class="card-icon red">🔍</div>
        <div class="card-titles">
          <div class="card-title">Log Inspector</div>
          <div class="card-author">por <b>Pedro Costa</b> <span class="sep">·</span> <span>v1.2.0</span></div>
        </div>
      </div>
      <div class="card-badges">
        <span class="badge badge-category">Ferramentas</span>
        <span class="badge badge-free">Grátis</span>
      </div>
      <p class="card-desc">Navega e filtra logs estruturados diretamente no SqlWizard. Suporte para JSON Lines, correlacionamento por request ID.</p>
      <div class="card-foot">
        <div class="card-price"><span class="amount gratis">Grátis</span></div>
        <a href="#" class="card-cta">Ver projeto <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17L17 7M17 7H9M17 7v8"/></svg></a>
      </div>
    </article>

    <article class="plugin-card">
      <div class="card-head">
        <div class="card-icon violet">📊</div>
        <div class="card-titles">
          <div class="card-title">Schema Diagram Pro</div>
          <div class="card-author">por <b>Onidesk Labs</b> <span class="sep">·</span> <span>v4.1.2</span></div>
        </div>
      </div>
      <div class="card-badges">
        <span class="badge badge-category cat-ui">UI / Tema</span>
        <span class="badge badge-paid">Pago</span>
      </div>
      <p class="card-desc">Editor visual de diagrama de base de dados. Export para PNG, SVG, PDF e documentação interativa.</p>
      <div class="card-foot">
        <div class="card-price"><span class="amount">€89</span><span class="period">vitalícia</span></div>
        <div class="card-actions"><a href="/marketplace/p/schema-diagram-pro" class="card-cta">Ver projeto <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17L17 7M17 7H9M17 7v8"/></svg></a><a href="#" class="card-cta card-cta-buy">Comprar <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a></div>
      </div>
    </article>

    <article class="plugin-card">
      <div class="card-head">
        <div class="card-icon amber">🔄</div>
        <div class="card-titles">
          <div class="card-title">Migration Helper</div>
          <div class="card-author">por <b>Beaver Team</b> <span class="sep">·</span> <span>v1.5.3</span></div>
        </div>
      </div>
      <div class="card-badges">
        <span class="badge badge-category cat-db">Base de dados</span>
        <span class="badge badge-free">Grátis</span>
      </div>
      <p class="card-desc">Gera migrations reversíveis a partir de diferenças entre esquemas. Suporte MySQL, PostgreSQL e SQLite.</p>
      <div class="card-foot">
        <div class="card-price"><span class="amount gratis">Grátis</span></div>
        <a href="#" class="card-cta">Ver projeto <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17L17 7M17 7H9M17 7v8"/></svg></a>
      </div>
    </article>

  </div>
</div>

<footer>
  © 2026 Beaver Framework · Created with <span class="accent">🦫</span> · an original idea of <b>J.Franco</b>
</footer>

<script>
  document.querySelectorAll('.filters-bar .chip').forEach(function (chip) {
    chip.addEventListener('click', function () {
      var label = chip.textContent.trim();
      var isTypeFilter = ['Todos', 'Grátis', 'Pagos'].some(function (t) { return label.indexOf(t) !== -1; });
      if (isTypeFilter) {
        document.querySelectorAll('.filters-bar .chip').forEach(function (c) {
          var cl = c.textContent.trim();
          if (['Todos', 'Grátis', 'Pagos'].some(function (t) { return cl.indexOf(t) !== -1; })) c.classList.remove('is-active');
        });
      }
      chip.classList.toggle('is-active');
    });
  });
  var searchInput = document.querySelector('.filters-search input');
  if (searchInput) {
    searchInput.addEventListener('input', function (e) {
      var q = e.target.value.toLowerCase().trim();
      document.querySelectorAll('.plugin-card').forEach(function (card) {
        var text = card.textContent.toLowerCase();
        card.style.display = text.indexOf(q) !== -1 ? '' : 'none';
      });
    });
  }
</script>

</body>
</html>
