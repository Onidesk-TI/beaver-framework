<?php

/**
 * Beaver Framework — Pro License
 */

declare(strict_types=1);

?>
<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Beaver Pro — Roe os problemas. Construa soluções.</title>
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
  --gold:#B45309;
  --gold-bg:rgba(180,83,9,.08);
  --gold-bd:rgba(180,83,9,.28);
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
  --gold:#FBBF24;
  --gold-bg:rgba(251,191,36,.10);
  --gold-bd:rgba(251,191,36,.30);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%}
html{scroll-behavior:smooth}
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
.pro-badge{
  font-size:.62rem;font-weight:800;letter-spacing:.08em;
  color:#FFF8EE;
  background:linear-gradient(135deg,#F59E0B,#E85D1F 60%,#C2410C);
  padding:3px 8px;border-radius:5px;
  margin-left:-4px;
}
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
  cursor:pointer;transition:.18s;flex:none;
}
.theme-toggle:hover{border-color:var(--accent);color:var(--accent)}
.theme-toggle svg{width:16px;height:16px}
[data-theme="light"] .icon-moon{display:none}
[data-theme="dark"]  .icon-sun{display:none}

/* ── Layout ── */
main{max-width:1000px;margin:0 auto;padding:56px 24px 80px}

/* ── HERO ── */
.hero{text-align:center;margin-bottom:64px;position:relative}
.hero .eyebrow{
  display:inline-flex;align-items:center;gap:8px;
  font-size:.72rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;
  color:var(--gold);
  background:var(--gold-bg);
  border:1px solid var(--gold-bd);
  padding:6px 14px;border-radius:100px;
  margin-bottom:20px;
}
.hero h1{
  font-size:clamp(2rem,4.5vw,3.2rem);
  line-height:1.08;letter-spacing:-.04em;font-weight:800;
  margin-bottom:20px;
}
.hero h1 .grad{
  background:linear-gradient(115deg,#F59E0B,#E85D1F 50%,#C2410C);
  -webkit-background-clip:text;background-clip:text;color:transparent;
}
.hero p.lead{
  font-size:1.05rem;color:var(--muted);max-width:640px;margin:0 auto 32px;
}
.hero p.lead strong{color:var(--text);font-weight:600}

.price-block{
  display:inline-flex;align-items:baseline;gap:12px;
  padding:20px 32px;border-radius:18px;
  background:var(--surface);
  border:1px solid var(--border);
  margin-bottom:24px;
}
.price-block b{
  font-size:2.6rem;font-weight:800;letter-spacing:-.04em;
  background:linear-gradient(135deg,#F59E0B,#C2410C);
  -webkit-background-clip:text;background-clip:text;color:transparent;
}
.price-block s{color:var(--muted);font-size:.95rem}
.price-block em{color:var(--muted);font-size:.85rem;font-style:normal}

.hero-cta{display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-bottom:20px}
.btn{
  display:inline-flex;align-items:center;justify-content:center;gap:9px;
  padding:14px 26px;border-radius:12px;font-weight:700;font-size:.95rem;
  border:1px solid transparent;transition:all .22s cubic-bezier(.4,0,.2,1);
  white-space:nowrap;letter-spacing:-.01em;cursor:pointer;text-decoration:none;
}
.btn-primary{
  background:linear-gradient(135deg,#F59E0B,#E85D1F 50%,#C2410C);
  color:#FFF8EE;
  box-shadow:0 10px 32px -12px rgba(232,93,31,.7);
}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 16px 40px -12px rgba(232,93,31,1)}
.btn-ghost{
  border-color:var(--border);
  background:var(--surface);
  color:var(--text);
}
.btn-ghost:hover{background:var(--surface-2);border-color:var(--accent);color:var(--accent)}
.hero-note{font-size:.82rem;color:var(--muted)}

/* ── Highlights ── */
.highlights{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:12px;
  margin-bottom:72px;
}
.hl{
  padding:20px 18px;border-radius:14px;
  background:var(--surface);
  border:1px solid var(--border);
  text-align:center;
  transition:.2s;
}
.hl:hover{
  border-color:color-mix(in srgb, var(--accent) 40%, var(--border));
  box-shadow:0 8px 24px -14px rgba(255,107,53,.3);
  transform:translateY(-2px);
}
.hl-ico{font-size:1.5rem;margin-bottom:8px;display:block}
.hl b{display:block;font-size:1.05rem;font-weight:800;letter-spacing:-.02em;margin-bottom:2px}
.hl span{font-size:.76rem;color:var(--muted)}

/* ── Section ── */
.section{margin-bottom:80px;scroll-margin-top:80px}
.section-head{margin-bottom:32px}
.section-eyebrow{
  display:inline-flex;align-items:center;gap:8px;
  font-size:.72rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;
  color:var(--accent);
  margin-bottom:12px;
}
.section-eyebrow::before{
  content:"";width:22px;height:1.5px;
  background:linear-gradient(90deg,var(--accent),transparent);
}
.section h2{
  font-size:clamp(1.5rem,3vw,2.1rem);
  font-weight:800;letter-spacing:-.03em;line-height:1.15;
  margin-bottom:10px;
}
.section p.sec-lead{color:var(--muted);font-size:.98rem;max-width:660px}

/* ── SQL Wizard Section ── */
.sql-demo{
  display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:28px;
}
.sql-pane{
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:14px;
  overflow:hidden;
}
.sql-pane-head{
  padding:12px 16px;
  background:var(--surface-2);
  border-bottom:1px solid var(--border);
  font-family:'JetBrains Mono',monospace;
  font-size:.76rem;
  color:var(--muted);
  display:flex;align-items:center;gap:8px;
}
.sql-pane-head .dot{
  width:8px;height:8px;border-radius:50%;background:var(--success);
}
.sql-pane-body{
  padding:16px 18px;
  font-family:'JetBrains Mono',monospace;
  font-size:.78rem;
  line-height:1.7;
  color:var(--text);
  overflow-x:auto;
}
.sql-pane-body .k{color:#BE185D}
.sql-pane-body .s{color:#B45309}
.sql-pane-body .c{color:var(--muted);font-style:italic}
.sql-pane-body .g{color:var(--success)}
.sql-pane-body .r{color:#DC2626}
.sql-pane-body .b{color:var(--doing)}

.sql-features{
  display:grid;grid-template-columns:repeat(2,1fr);gap:14px;margin-top:24px;
}
.sql-feat{
  padding:16px 18px;
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:12px;
  display:flex;gap:12px;align-items:flex-start;
}
.sql-feat .ico{
  width:34px;height:34px;border-radius:9px;flex:none;
  display:grid;place-items:center;font-size:1rem;
  background:var(--gold-bg);
  border:1px solid var(--gold-bd);
}
.sql-feat b{display:block;font-size:.9rem;font-weight:700;margin-bottom:4px}
.sql-feat p{font-size:.82rem;color:var(--muted);line-height:1.5}

/* ── Plugins grid ── */
.plugins-grid{
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(180px,1fr));
  gap:12px;
  margin-top:24px;
}
.plugin{
  padding:16px 16px 18px;
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:12px;
  transition:.2s;
}
.plugin:hover{
  border-color:color-mix(in srgb, var(--accent) 45%, var(--border));
  transform:translateY(-2px);
  box-shadow:0 8px 24px -14px rgba(255,107,53,.28);
}
.plugin .ico{
  width:32px;height:32px;border-radius:8px;
  display:grid;place-items:center;font-size:1rem;
  background:color-mix(in srgb, var(--accent) 12%, transparent);
  border:1px solid color-mix(in srgb, var(--accent) 25%, transparent);
  margin-bottom:10px;
}
.plugin b{display:block;font-size:.86rem;font-weight:700;letter-spacing:-.01em;margin-bottom:2px}
.plugin span{font-size:.74rem;color:var(--muted);line-height:1.4}

.plugin-cat{
  margin-top:36px;margin-bottom:12px;
  display:flex;align-items:center;gap:10px;
  font-size:.72rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;
  color:var(--muted);
}
.plugin-cat::after{
  content:"";flex:1;height:1px;background:var(--border);
}

/* ── Console ── */
.console{
  background:linear-gradient(180deg,#0E1520,#0A0F16);
  border:1px solid rgba(255,255,255,.14);
  border-radius:16px;
  overflow:hidden;
  margin-top:28px;
  box-shadow:0 40px 90px -30px rgba(0,0,0,.95);
}
.console-head{
  padding:12px 16px;
  background:rgba(255,255,255,.025);
  border-bottom:1px solid rgba(255,255,255,.06);
  display:flex;align-items:center;gap:12px;
}
.console-dots{display:flex;gap:7px}
.console-dots i{width:11px;height:11px;border-radius:50%}
.console-dots i:nth-child(1){background:#FF5F57}
.console-dots i:nth-child(2){background:#FEBC2E}
.console-dots i:nth-child(3){background:#28C840}
.console-title{
  font-family:'JetBrains Mono',monospace;
  font-size:.74rem;color:#8895A7;
  margin:0 auto;
}
.console-body{
  padding:20px 24px;
  font-family:'JetBrains Mono',monospace;
  font-size:.76rem;
  line-height:1.75;
  color:#E8EEF6;
  min-height:260px;
  overflow-x:auto;
}
.console-body .line{display:block;white-space:pre}
.console-body .pmt{color:#3DDC97}
.console-body .str{color:#FFC46B}
.console-body .cmd{color:#7FE3C4}
.console-body .out{color:#5F7085}
.console-body .ok{color:#4ADE80}
.console-body .warn{color:#FBBF24}
.console-body .err{color:#EF4444}
.console-body .kw{color:#FF7EB6}
.console-body .cur{
  display:inline-block;width:8px;height:14px;background:#FF9A3C;
  vertical-align:-2px;border-radius:1px;animation:blink 1.05s steps(2) infinite;
}
@keyframes blink{0%,49%{opacity:1}50%,100%{opacity:0}}

.console-feats{
  display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-top:24px;
}

/* ── Tests ── */
.test-runner{
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:14px;
  overflow:hidden;
  margin-top:28px;
}
.test-head{
  padding:12px 16px;
  background:var(--surface-2);
  border-bottom:1px solid var(--border);
  display:flex;align-items:center;gap:10px;
  font-family:'JetBrains Mono',monospace;font-size:.76rem;color:var(--muted);
}
.test-body{
  padding:16px 20px;
  font-family:'JetBrains Mono',monospace;
  font-size:.78rem;
  line-height:1.8;
  overflow-x:auto;
}
.test-body .pass{color:var(--success)}
.test-body .fail{color:#DC2626}
.test-body .mute{color:var(--muted)}
.test-body .stat{
  margin-top:10px;padding-top:10px;border-top:1px solid var(--border);
  color:var(--text);font-weight:600;
}

/* ── Ferramentas extras ── */
.tools-grid{
  display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-top:28px;
}
.tool{
  padding:22px 20px;
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:14px;
  transition:.2s;
}
.tool:hover{
  border-color:color-mix(in srgb, var(--accent) 40%, var(--border));
  transform:translateY(-3px);
  box-shadow:0 12px 32px -18px rgba(255,107,53,.35);
}
.tool .ico{
  width:40px;height:40px;border-radius:11px;
  display:grid;place-items:center;font-size:1.15rem;
  background:linear-gradient(140deg,rgba(245,158,11,.18),rgba(232,93,31,.04));
  border:1px solid rgba(232,93,31,.22);
  margin-bottom:14px;
}
.tool b{display:block;font-size:.98rem;font-weight:800;letter-spacing:-.015em;margin-bottom:6px}
.tool p{font-size:.84rem;color:var(--muted);line-height:1.55}

/* ── Comparação ── */
.compare{
  width:100%;
  border-collapse:collapse;
  margin-top:28px;
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:14px;
  overflow:hidden;
}
.compare th,.compare td{
  padding:14px 18px;
  text-align:left;
  border-bottom:1px solid var(--border);
  font-size:.88rem;
}
.compare th{
  background:var(--surface-2);
  font-size:.72rem;font-weight:800;letter-spacing:.12em;
  text-transform:uppercase;color:var(--muted);
}
.compare th.center, .compare td.center{text-align:center}
.compare td:first-child{font-weight:600}
.compare tr:last-child td{border-bottom:none}
.compare .yes{color:var(--success);font-weight:800}
.compare .no{color:var(--muted);font-weight:600}
.compare .pro-col{background:color-mix(in srgb, var(--gold) 6%, transparent)}

/* ── FAQ ── */
.faq{margin-top:28px}
.faq-item{
  padding:18px 22px;
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:12px;
  margin-bottom:10px;
  cursor:pointer;
  transition:.2s;
}
.faq-item[open]{border-color:var(--border-2);background:var(--surface)}
.faq-item summary{
  list-style:none;
  font-weight:700;font-size:.95rem;
  display:flex;align-items:center;gap:10px;
  cursor:pointer;
}
.faq-item summary::-webkit-details-marker{display:none}
.faq-item summary::before{
  content:"+";
  width:22px;height:22px;border-radius:6px;
  display:grid;place-items:center;
  background:color-mix(in srgb, var(--accent) 12%, transparent);
  border:1px solid color-mix(in srgb, var(--accent) 25%, transparent);
  color:var(--accent);
  font-weight:800;font-size:.9rem;
  transition:.2s;
}
.faq-item[open] summary::before{content:"−";transform:rotate(180deg)}
.faq-item p{
  margin-top:12px;font-size:.88rem;color:var(--muted);line-height:1.6;
  padding-left:32px;
}

/* ── CTA Final ── */
.cta-final{
  border-radius:22px;
  padding:56px 44px;
  text-align:center;
  position:relative;overflow:hidden;
  background:linear-gradient(150deg,#FFFBEB,#FBF6EE 70%);
  border:1px solid var(--gold-bd);
  margin-top:40px;
}
[data-theme="dark"] .cta-final{
  background:linear-gradient(150deg,#1A1408,#0A0F16 70%);
  border-color:var(--gold-bd);
}
.cta-final::before{
  content:"";position:absolute;width:600px;height:600px;border-radius:50%;
  left:50%;top:-340px;transform:translateX(-50%);
  background:radial-gradient(circle,rgba(245,158,11,.28),transparent 65%);
  filter:blur(50px);
}
.cta-final > *{position:relative;z-index:1}
.cta-final h2{
  font-size:clamp(1.6rem,3vw,2.2rem);
  font-weight:800;letter-spacing:-.035em;
  margin-bottom:12px;line-height:1.15;
}
.cta-final p{
  color:var(--muted);font-size:.98rem;max-width:520px;
  margin:0 auto 28px;
}

/* ── Footer ── */
footer{
  text-align:center;padding:22px 24px;
  border-top:1px solid var(--border);
  color:var(--muted);font-size:.8rem;
  margin-top:60px;
}
footer .accent{color:var(--accent)}

/* ── Responsivo ── */
@media(max-width:860px){
  .highlights{grid-template-columns:repeat(2,1fr)}
  .sql-demo{grid-template-columns:1fr}
  .sql-features{grid-template-columns:1fr}
  .console-feats{grid-template-columns:1fr}
  .tools-grid{grid-template-columns:1fr 1fr}
  .compare th,.compare td{padding:11px 12px;font-size:.8rem}
}
@media(max-width:620px){
  main{padding:32px 18px 60px}
  .highlights{grid-template-columns:1fr}
  .tools-grid{grid-template-columns:1fr}
  .cta-final{padding:40px 22px}
  .price-block{padding:16px 22px}
  .price-block b{font-size:2rem}
  .back-link span{display:none}
  .compare th:first-child,.compare td:first-child{min-width:120px}
}
</style>
</head>
<body>

<?php
$active  = 'pro';
$version = $version ?? beaver_version();
require __DIR__ . '/partials/header-docs.php';
?>

<main>

  <!-- ── HERO ── -->
  <section class="hero">
    <span class="eyebrow">🦫 Licença Comercial</span>
    <h1>
      Beaver <span class="grad">Pro License</span>
    </h1>
    <p class="lead">
      A versão completa do <strong>Beaver Framework</strong> — com
      <strong>SqlAnalyser Pro</strong>, mais de <strong>50 plugins oficiais</strong>,
      <strong>consola de produção</strong>, testes unitários integrados e todas as
      ferramentas para levar software sólido para produção.
    </p>

    <div class="price-block">
      <b>€129</b>
      <s>€172</s>
      <em>/ano · 1 projeto</em>
    </div>

    <div class="hero-cta">
      <a href="#comprar" class="btn btn-primary">
        Comprar licença
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </a>
      <a href="#comparar" class="btn btn-ghost">Ver o que inclui</a>
    </div>
    <p class="hero-note">Fatura com IVA · Ativação imediata · Suporte prioritário 24h</p>
  </section>

  <!-- ── Highlights ── -->
  <section class="highlights">
    <div class="hl">
      <span class="hl-ico">🗄️</span>
      <b>SqlAnalyser Pro</b>
      <span>Query Profiler + Explain Visual</span>
    </div>
    <div class="hl">
      <span class="hl-ico">🔌</span>
      <b>50+ Plugins</b>
      <span>Ecossistema oficial completo</span>
    </div>
    <div class="hl">
      <span class="hl-ico">📊</span>
      <b>Consola de Produção</b>
      <span>Monitorização em tempo real</span>
    </div>
    <div class="hl">
      <span class="hl-ico">🧪</span>
      <b>Testes Integrados</b>
      <span>PHPUnit + factories + runner</span>
    </div>
  </section>

  <!-- ── SQL WIZARD ── -->
  <section class="section" id="sql">
    <div class="section-head">
      <div class="section-eyebrow">Base de dados</div>
      <h2>Configuração completa com SqlAnalyser</h2>
      <p class="sec-lead">
        O <strong>SqlAnalyser Pro</strong> captura, analisa e explica cada query em tempo real.
        Detecta N+1, sugere índices, mostra planos de execução e integra-se diretamente no
        container do Beaver.
      </p>
    </div>

    <div class="sql-demo">
      <div class="sql-pane">
        <div class="sql-pane-head"><span class="dot"></span> app/Config/Database.php</div>
        <div class="sql-pane-body">
<span class="c">// Conexão + perfilagem automática</span>
<span class="k">return</span> [
    <span class="s">'default'</span> =&gt; <span class="s">'mysql'</span>,
    <span class="s">'connections'</span> =&gt; [
        <span class="s">'mysql'</span> =&gt; [
            <span class="s">'host'</span>     =&gt; env(<span class="s">'DB_HOST'</span>),
            <span class="s">'database'</span> =&gt; env(<span class="s">'DB_DATABASE'</span>),
            <span class="s">'user'</span>     =&gt; env(<span class="s">'DB_USER'</span>),
            <span class="s">'password'</span> =&gt; env(<span class="s">'DB_PASS'</span>),

            <span class="c">// ⚡ SqlAnalyser Pro</span>
            <span class="s">'profiler'</span> =&gt; [
                <span class="s">'enabled'</span>       =&gt; <span class="k">true</span>,
                <span class="s">'explain'</span>       =&gt; <span class="k">true</span>,
                <span class="s">'log_slow'</span>      =&gt; <span class="b">100</span>, <span class="c">// ms</span>
                <span class="s">'detect_n1'</span>     =&gt; <span class="k">true</span>,
                <span class="s">'suggest_index'</span> =&gt; <span class="k">true</span>,
            ],
        ],
    ],
];
        </div>
      </div>

      <div class="sql-pane">
        <div class="sql-pane-head"><span class="dot"></span> beaver db:analyse</div>
        <div class="sql-pane-body">
<span class="g">✔ 1.284 queries capturadas</span>

<span class="c">⏱ Top 3 mais lentas:</span>
  <span class="r">412 ms</span>  SELECT * FROM produtos
         WHERE categoria_id = ? <span class="c">// N+1 detectado</span>
  <span class="r">238 ms</span>  SELECT * FROM pedidos
         WHERE status = ? <span class="c">// falta índice</span>
  <span class="r"> 91 ms</span>  UPDATE stock SET qtd = ?

<span class="c">💡 Sugestões:</span>
  <span class="b">→</span> Adicionar índice em <span class="s">produtos.categoria_id</span>
  <span class="b">→</span> Eager loading em <span class="s">Categoria::with('produtos')</span>
  <span class="b">→</span> Cache de 60s para listagens

<span class="g">✔ Ganho estimado: -78% tempo</span>
        </div>
      </div>
    </div>

    <div class="sql-features">
      <div class="sql-feat">
        <span class="ico">⚡</span>
        <div>
          <b>Query Profiler</b>
          <p>Todas as queries, tempos, bindings e trace de origem em tempo real.</p>
        </div>
      </div>
      <div class="sql-feat">
        <span class="ico">🔍</span>
        <div>
          <b>Detecção de N+1</b>
          <p>Avisa quando uma listagem dispara consultas em loop e sugere eager loading.</p>
        </div>
      </div>
      <div class="sql-feat">
        <span class="ico">📈</span>
        <div>
          <b>Explain Visual</b>
          <p>Planos de execução interativos, com custo por passo e sugestões de índice.</p>
        </div>
      </div>
      <div class="sql-feat">
        <span class="ico">🧩</span>
        <div>
          <b>Sugestão de Índices</b>
          <p>Analisa padrões de consulta e propõe índices compostos adequados ao tráfego real.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ── PLUGINS ── -->
  <section class="section" id="plugins">
    <div class="section-head">
      <div class="section-eyebrow">Ecossistema</div>
      <h2>Mais de 50 plugins oficiais</h2>
      <p class="sec-lead">
        Tudo o que precisas, pronto a instalar com <code style="font-family:'JetBrains Mono',monospace;font-size:.85em;background:var(--surface-2);padding:2px 6px;border-radius:4px">beaver plugin:install &lt;nome&gt;</code>.
        Atualizações automáticas, compatibilidade garantida e suporte oficial.
      </p>
    </div>

    <div class="plugin-cat">Autenticação &amp; Segurança</div>
    <div class="plugins-grid">
      <div class="plugin"><div class="ico">🔑</div><b>Frankey Auth</b><span>JWT, 2FA e RBAC</span></div>
      <div class="plugin"><div class="ico">🛡️</div><b>Shield WAF</b><span>Firewall de aplicação</span></div>
      <div class="plugin"><div class="ico">🔒</div><b>Vault Keys</b><span>Gestão de segredos</span></div>
      <div class="plugin"><div class="ico">👤</div><b>Social Login</b><span>OAuth Google/GitHub</span></div>
      <div class="plugin"><div class="ico">📱</div><b>TOTP 2FA</b><span>Autenticação em 2 passos</span></div>
      <div class="plugin"><div class="ico">🎫</div><b>API Tokens</b><span>Chaves por utilizador</span></div>
    </div>

    <div class="plugin-cat">Base de dados &amp; Performance</div>
    <div class="plugins-grid">
      <div class="plugin"><div class="ico">🗄️</div><b>SqlAnalyser Pro</b><span>Profiler + Explain</span></div>
      <div class="plugin"><div class="ico">⚡</div><b>Redis Cache</b><span>Cache distribuída</span></div>
      <div class="plugin"><div class="ico">📦</div><b>Query Cache</b><span>Resultados em memória</span></div>
      <div class="plugin"><div class="ico">🔁</div><b>Replicas Read</b><span>Leitura/escrita separadas</span></div>
      <div class="plugin"><div class="ico">💾</div><b>Backup Auto</b><span>Backups agendados</span></div>
      <div class="plugin"><div class="ico">🧬</div><b>Migrations Plus</b><span>Migrações zero-downtime</span></div>
    </div>

    <div class="plugin-cat">Comunicação</div>
    <div class="plugins-grid">
      <div class="plugin"><div class="ico">📧</div><b>Mailer Pro</b><span>SMTP + templates</span></div>
      <div class="plugin"><div class="ico">💬</div><b>SMS Gateway</b><span>Twilio, Vonage</span></div>
      <div class="plugin"><div class="ico">🔔</div><b>Push Notify</b><span>Web + FCM</span></div>
      <div class="plugin"><div class="ico">📨</div><b>Queue Mailer</b><span>Envio assíncrono</span></div>
      <div class="plugin"><div class="ico">🤖</div><b>Slack Bridge</b><span>Alertas para Slack</span></div>
      <div class="plugin"><div class="ico">📱</div><b>WhatsApp API</b><span>Cloud API oficial</span></div>
    </div>

    <div class="plugin-cat">Infraestrutura &amp; Deploy</div>
    <div class="plugins-grid">
      <div class="plugin"><div class="ico">🐳</div><b>Docker Kit</b><span>Dockerfile + compose</span></div>
      <div class="plugin"><div class="ico">🚀</div><b>Deployer</b><span>Deploy com um comando</span></div>
      <div class="plugin"><div class="ico">⚙️</div><b>Env Manager</b><span>Gestão de .env</span></div>
      <div class="plugin"><div class="ico">📊</div><b>Health Check</b><span>Endpoints de saúde</span></div>
      <div class="plugin"><div class="ico">📝</div><b>Structured Logs</b><span>Logs JSON estruturados</span></div>
      <div class="plugin"><div class="ico">🔍</div><b>Tracer</b><span>Distributed tracing</span></div>
    </div>

    <div class="plugin-cat">Conteúdo &amp; Media</div>
    <div class="plugins-grid">
      <div class="plugin"><div class="ico">🖼️</div><b>Media Library</b><span>Uploads e thumbnails</span></div>
      <div class="plugin"><div class="ico">📝</div><b>Markdown Editor</b><span>Editor + preview</span></div>
      <div class="plugin"><div class="ico">🌍</div><b>i18n</b><span>Multi-idioma</span></div>
      <div class="plugin"><div class="ico">📄</div><b>PDF Generator</b><span>Faturas, relatórios</span></div>
      <div class="plugin"><div class="ico">📊</div><b>Excel Export</b><span>XLSX / CSV</span></div>
      <div class="plugin"><div class="ico">🔎</div><b>Full-text Search</b><span>Scout + Meilisearch</span></div>
    </div>

    <div class="plugin-cat">Pagamentos &amp; Negócio</div>
    <div class="plugins-grid">
      <div class="plugin"><div class="ico">💳</div><b>Stripe Pro</b><span>Subscrições + webhooks</span></div>
      <div class="plugin"><div class="ico">🏦</div><b>MB Way</b><span>Pagamentos PT</span></div>
      <div class="plugin"><div class="ico">🧾</div><b>Invoice PT</b><span>Faturação certificada</span></div>
      <div class="plugin"><div class="ico">🛒</div><b>E-commerce Core</b><span>Carrinho + checkout</span></div>
      <div class="plugin"><div class="ico">📈</div><b>Analytics</b><span>Métricas de negócio</span></div>
      <div class="plugin"><div class="ico">🎟️</div><b>Licensing</b><span>Chaves de licença</span></div>
    </div>

    <div class="plugin-cat">Developer Tools</div>
    <div class="plugins-grid">
      <div class="plugin"><div class="ico">🧰</div><b>Dev Toolbar</b><span>Barra de debug</span></div>
      <div class="plugin"><div class="ico">🧪</div><b>Test Factories</b><span>Geração de dados fake</span></div>
      <div class="plugin"><div class="ico">🔬</div><b>Coverage Report</b><span>Cobertura de testes</span></div>
      <div class="plugin"><div class="ico">⌨️</div><b>Command Bus</b><span>Comandos CLI custom</span></div>
      <div class="plugin"><div class="ico">📡</div><b>Event Inspector</b><span>Debug de eventos</span></div>
      <div class="plugin"><div class="ico">🕵️</div><b>Profiler</b><span>Perfil de performance</span></div>
    </div>
  </section>

  <!-- ── CONSOLA ── -->
  <section class="section" id="consola">
    <div class="section-head">
      <div class="section-eyebrow">Produção</div>
      <h2>Consola de produção integrada</h2>
      <p class="sec-lead">
        Um painel de controlo no teu servidor, sem dependências externas. Monitoriza CPU, memória,
        queries, jobs, erros e alertas — tudo em tempo real.
      </p>
    </div>

    <div class="console">
      <div class="console-head">
        <div class="console-dots"><i></i><i></i><i></i></div>
        <div class="console-title">beaver console · produção</div>
      </div>
      <div class="console-body">
<span class="line out">──────────────────────────────────────────────────────────────</span>
<span class="line out">  BEAVER PRO · production                     ⏱ uptime 14d 3h</span>
<span class="line out">──────────────────────────────────────────────────────────────</span>
<span class="line">  <span class="cmd">CPU</span>        <span class="ok">████████░░ 38%</span>    </span>
<span class="line">  <span class="cmd">RAM</span>        <span class="ok">██████░░░░ 512 MB / 1.0 GB</span></span>
<span class="line">  <span class="cmd">Disco</span>      <span class="warn">████████░░ 82%</span>  <span class="out">// atenção</span></span>
<span class="line"> </span>
<span class="line">  <span class="cmd">Requests</span>   12.482 / min       <span class="ok">↑ 4.2%</span></span>
<span class="line">  <span class="cmd">Latência</span>   34 ms médio       <span class="ok">↓ 8.1%</span></span>
<span class="line">  <span class="cmd">Erros</span>      <span class="ok">0.02%</span>             <span class="ok">↓ 62%</span></span>
<span class="line"> </span>
<span class="line">  <span class="cmd">Queries</span>    8.914 / min       <span class="warn">2 N+1</span></span>
<span class="line">  <span class="cmd">Cache</span>      <span class="ok">hits 94.6%</span>         <span class="out">miss 5.4%</span></span>
<span class="line">  <span class="cmd">Jobs</span>       <span class="ok">1.024 na fila</span>      <span class="ok">0 falhas</span></span>
<span class="line"> </span>
<span class="line out">──────────────────────────────────────────────────────────────</span>
<span class="line">  <span class="warn">⚠  Alerta:</span> <span class="out">Disco acima de 80% no volume /var</span></span>
<span class="line">  <span class="ok">✔  Último deploy:</span> <span class="out">há 2h · commit 4f8c2a1 · ok</span></span>
<span class="line out">──────────────────────────────────────────────────────────────</span>
<span class="line">  <span class="pmt">beaver&gt;</span> <span class="cur"></span></span>
      </div>
    </div>

    <div class="console-feats">
      <div class="tool">
        <div class="ico">📊</div>
        <b>Monitorização</b>
        <p>CPU, memória, disco, rede e latência em tempo real, sem agentes externos.</p>
      </div>
      <div class="tool">
        <div class="ico">🔔</div>
        <b>Alertas</b>
        <p>Notificações por email, Slack ou webhook quando um limite é ultrapassado.</p>
      </div>
      <div class="tool">
        <div class="ico">🚀</div>
        <b>Deploys</b>
        <p>Histórico de deploys, rollback com um comando e diff de configuração.</p>
      </div>
    </div>
  </section>

  <!-- ── TESTES ── -->
  <section class="section" id="testes">
    <div class="section-head">
      <div class="section-eyebrow">Qualidade</div>
      <h2>Testes unitários e de integração</h2>
      <p class="sec-lead">
        PHPUnit integrado, factories automáticas, base de dados em memória e um runner
        paralelo que corta o tempo de CI para metade.
      </p>
    </div>

    <div class="test-runner">
      <div class="test-head">
        <span class="dot" style="width:8px;height:8px;border-radius:50%;background:var(--success);display:inline-block"></span>
        beaver test --parallel
      </div>
      <div class="test-body">
<span class="pass">PASS</span>  Tests\Unit\ProdutoTest
<span class="pass">PASS</span>  Tests\Unit\CategoriaTest
<span class="pass">PASS</span>  Tests\Unit\ValidadorTest
<span class="pass">PASS</span>  Tests\Feature\AuthTest
<span class="pass">PASS</span>  Tests\Feature\ProdutoControllerTest
<span class="pass">PASS</span>  Tests\Feature\CheckoutTest
<span class="pass">PASS</span>  Tests\Feature\SqlAnalyserTest
<span class="mute">─────────────────────────────────────</span>
<span class="stat">Testes: 42 passaram · Duração: 1.28s · Cobertura: 94.2%</span>
      </div>
    </div>

    <div class="sql-features" style="margin-top:24px">
      <div class="sql-feat">
        <span class="ico">🧪</span>
        <div>
          <b>PHPUnit Pré-configurado</b>
          <p>Instala e começa a escrever testes sem configuração extra.</p>
        </div>
      </div>
      <div class="sql-feat">
        <span class="ico">🏭</span>
        <div>
          <b>Factories automáticas</b>
          <p><code style="font-family:'JetBrains Mono',monospace;font-size:.82em">Produto::factory(50)-&gt;create()</code> gera dados realistas.</p>
        </div>
      </div>
      <div class="sql-feat">
        <span class="ico">⚡</span>
        <div>
          <b>Runner paralelo</b>
          <p>Divide os testes por cores e reduz o tempo em 60%.</p>
        </div>
      </div>
      <div class="sql-feat">
        <span class="ico">📊</span>
        <div>
          <b>Cobertura visual</b>
          <p>Relatórios HTML de cobertura, por ficheiro e por linha.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ── FERRAMENTAS ── -->
  <section class="section" id="ferramentas">
    <div class="section-head">
      <div class="section-eyebrow">Extras</div>
      <h2>Ferramentas que acompanham o desenvolvimento</h2>
      <p class="sec-lead">
        Mais do que uma licença — um kit completo para construir, monitorizar e escalar
        aplicações PHP modernas.
      </p>
    </div>

    <div class="tools-grid">
      <div class="tool">
        <div class="ico">⌨️</div>
        <b>Beaver CLI Plus</b>
        <p>Geradores de código, comandos custom, Tinker interativo e atalhos de produtividade.</p>
      </div>
      <div class="tool">
        <div class="ico">🧬</div>
        <b>Component Creator</b>
        <p>Cria componentes completos com <code style="font-family:'JetBrains Mono',monospace;font-size:.82em">make:component</code> — modelo, migração, controller, views e rotas.</p>
      </div>
      <div class="tool">
        <div class="ico">🎨</div>
        <b>Theme SDK</b>
        <p>Editor visual de temas, preview ao vivo, variáveis CSS e exportação para produção.</p>
      </div>
      <div class="tool">
        <div class="ico">🔐</div>
        <b>Frankey Auth</b>
        <p>JWT, 2FA, RBAC e API keys num único pacote, com integração nativa no Beaver.</p>
      </div>
      <div class="tool">
        <div class="ico">🚀</div>
        <b>Deployer</b>
        <p>Deploy atómico, sem downtime, com rollback automático em caso de falha.</p>
      </div>
      <div class="tool">
        <div class="ico">📚</div>
        <b>Docs Generator</b>
        <p>Gera documentação da tua API a partir de anotações ou código, com exemplos reais.</p>
      </div>
      <div class="tool">
        <div class="ico">🧵</div>
        <b>Queue &amp; Scheduler</b>
        <p>Jobs em background, retries automáticos e agendador cron-like integrado.</p>
      </div>
      <div class="tool">
        <div class="ico">🔔</div>
        <b>Events &amp; Listeners</b>
        <p>Sistema de eventos desacoplado com prioridades e filtros declarativos.</p>
      </div>
      <div class="tool">
        <div class="ico">📦</div>
        <b>Package Builder</b>
        <p>Empacota e publica os teus próprios plugins no Beaver Hub com um comando.</p>
      </div>
    </div>
  </section>

  <!-- ── COMPARAÇÃO ── -->
  <section class="section" id="comparar">
    <div class="section-head">
      <div class="section-eyebrow">Comparação</div>
      <h2>O que muda com a licença Pro</h2>
      <p class="sec-lead">
        O Beaver Framework é gratuito e continuará a ser. A licença Pro adiciona as
        ferramentas profissionais que precisas para projetos comerciais.
      </p>
    </div>

    <table class="compare">
      <thead>
        <tr>
          <th>Funcionalidade</th>
          <th class="center">Community</th>
          <th class="center pro-col">Pro License</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Framework core</td>
          <td class="center yes">✓</td>
          <td class="center pro-col yes">✓</td>
        </tr>
        <tr>
          <td>CLI básica</td>
          <td class="center yes">✓</td>
          <td class="center pro-col yes">✓</td>
        </tr>
        <tr>
          <td>Routing, ORM, Validation</td>
          <td class="center yes">✓</td>
          <td class="center pro-col yes">✓</td>
        </tr>
        <tr>
          <td>SqlAnalyser (Query Profiler)</td>
          <td class="center no">—</td>
          <td class="center pro-col yes">✓</td>
        </tr>
        <tr>
          <td>Explain Visual + Sugestão de índices</td>
          <td class="center no">—</td>
          <td class="center pro-col yes">✓</td>
        </tr>
        <tr>
          <td>Consola de produção</td>
          <td class="center no">—</td>
          <td class="center pro-col yes">✓</td>
        </tr>
        <tr>
          <td>50+ plugins oficiais</td>
          <td class="center no">—</td>
          <td class="center pro-col yes">✓</td>
        </tr>
        <tr>
          <td>Theme SDK Pro (editor visual)</td>
          <td class="center no">—</td>
          <td class="center pro-col yes">✓</td>
        </tr>
        <tr>
          <td>Deployer + rollback</td>
          <td class="center no">—</td>
          <td class="center pro-col yes">✓</td>
        </tr>
        <tr>
          <td>Suporte prioritário</td>
          <td class="center no">—</td>
          <td class="center pro-col yes">✓</td>
        </tr>
        <tr>
          <td>Atualizações contínuas</td>
          <td class="center yes">✓</td>
          <td class="center pro-col yes">✓</td>
        </tr>
      </tbody>
    </table>
  </section>

  <!-- ── FAQ ── -->
  <section class="section" id="faq">
    <div class="section-head">
      <div class="section-eyebrow">Perguntas frequentes</div>
      <h2>Ainda com dúvidas?</h2>
    </div>

    <details class="faq-item">
      <summary>Posso usar a licença em vários projetos?</summary>
      <p>Cada licença Pro cobre 1 projeto comercial. Para agências ou múltiplos projetos, temos licenças Team (5 projetos) e Enterprise (ilimitado). Contacta-nos para um orçamento.</p>
    </details>

    <details class="faq-item">
      <summary>O que acontece quando a licença expira?</summary>
      <p>O software continua a funcionar, mas deixas de receber atualizações e suporte prioritário. Podes renovar a qualquer momento, sem penalização.</p>
    </details>

    <details class="faq-item">
      <summary>Os 50+ plugins estão incluídos?</summary>
      <p>Sim — todos os plugins oficiais publicados no Beaver Hub estão incluídos durante a vigência da licença, com atualizações automáticas.</p>
    </details>

    <details class="faq-item">
      <summary>Como funciona a ativação?</summary>
      <p>Recebes uma chave por email após a compra. Introduzes no <code style="font-family:'JetBrains Mono',monospace;font-size:.85em;background:var(--surface-2);padding:2px 6px;border-radius:4px">.env</code> como <code style="font-family:'JetBrains Mono',monospace;font-size:.85em;background:var(--surface-2);padding:2px 6px;border-radius:4px">BEAVER_LICENSE_KEY=...</code> e a licença é validada automaticamente.</p>
    </details>

    <details class="faq-item">
      <summary>Posso experimentar antes de comprar?</summary>
      <p>Sim — todos os plugins Pro têm 14 dias de trial. Ativa com <code style="font-family:'JetBrains Mono',monospace;font-size:.85em;background:var(--surface-2);padding:2px 6px;border-radius:4px">beaver license:trial</code>.</p>
    </details>

    <details class="faq-item">
      <summary>Emitem fatura com IVA?</summary>
      <p>Sim, faturas com IVA português para empresas nacionais e inversão do sujeito passivo para empresas da UE com VAT válido.</p>
    </details>
  </section>

  <!-- ── CTA FINAL ── -->
  <section class="cta-final" id="comprar">
    <h2>Pronto para construir a sério?</h2>
    <p>
      Junta-te a mais de 18.000 developers que já usam o Beaver para entregar software sólido
      em produção. Ativação imediata, cancele quando quiseres.
    </p>
    <div class="hero-cta">
      <a href="#" class="btn btn-primary" style="padding:16px 32px">
        Comprar Beaver Pro — €129/ano
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </a>
      <a href="/manual" class="btn btn-ghost" style="padding:16px 32px">Ver manual completo</a>
    </div>
    <p style="margin-top:20px;font-size:.82rem;color:var(--muted)">
      Fatura com IVA · Ativação imediata · Suporte prioritário · Cancele quando quiser
    </p>
  </section>

</main>

<footer>
  Beaver Framework · feito com <span class="accent">🦫</span> · <span id="year"></span> · <a href="/" style="color:var(--accent);text-decoration:none">Voltar à página inicial</a>
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
