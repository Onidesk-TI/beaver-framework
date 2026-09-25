<?php

/**
 * Beaver Framework — Landing page
 *
 * Página inicial com seletor de design (Black / Âmbar).
 * Design persistido via localStorage.
 */

declare(strict_types=1);

?>
<!DOCTYPE html>
<html lang="pt" data-design="amber">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Beaver Framework — Roí os problemas. Constrói soluções.</title>
<!-- evita flash de tema errado -->
<script>
  (function () {
    try {
      var saved = localStorage.getItem('beaver-design');
      var design = (saved === 'amber' || saved === 'black') ? saved : 'amber';
      document.documentElement.setAttribute('data-design', design);
    } catch (e) {
      document.documentElement.setAttribute('data-design', 'amber');
    }
  })();
</script>
<meta name="description" content="Beaver Framework: a framework da comunidade. Um framework PHP moderno, rápido e opinativo. Documentação, SqlAnalyser, Frankey e loja oficial.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<style>
/* ============ RESET / BASE ============ */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#070A0F;
  --bg-2:#0B1017;
  --card:#0F1620;
  --card-2:#121A26;
  --line:rgba(255,255,255,.07);
  --line-strong:rgba(255,255,255,.14);
  --text:#E8EEF6;
  --muted:#8895A7;
  --amber:#FF9A3C;
  --amber-2:#FF6B35;
  --amber-3:#FFC46B;
  --green:#3DDC97;
  --violet:#8B7BFF;
  --radius:16px;
  --shadow:0 24px 60px -24px rgba(0,0,0,.9);
}
html{scroll-behavior:smooth}
body{
  font-family:'Inter',system-ui,-apple-system,sans-serif;
  background:var(--bg);
  color:var(--text);
  line-height:1.65;
  -webkit-font-smoothing:antialiased;
  overflow-x:hidden;
  transition:background .3s, color .3s;
}
body::before{
  content:"";
  position:fixed;inset:0;z-index:-2;
  background:
    radial-gradient(900px 500px at 12% -8%, rgba(255,154,60,.16), transparent 62%),
    radial-gradient(760px 460px at 88% 4%, rgba(139,123,255,.13), transparent 60%),
    radial-gradient(700px 500px at 50% 110%, rgba(255,107,53,.08), transparent 65%);
  transition:background .3s;
}
body::after{
  content:"";
  position:fixed;inset:0;z-index:-1;pointer-events:none;
  background-image:linear-gradient(rgba(255,255,255,.022) 1px,transparent 1px),
                   linear-gradient(90deg,rgba(255,255,255,.022) 1px,transparent 1px);
  background-size:56px 56px;
  mask-image:radial-gradient(ellipse 90% 60% at 50% 0%,#000 20%,transparent 75%);
  -webkit-mask-image:radial-gradient(ellipse 90% 60% at 50% 0%,#000 20%,transparent 75%);
  transition:background-image .3s;
}
img,svg{display:block;max-width:100%}
a{color:inherit;text-decoration:none}
button{font-family:inherit;cursor:pointer;border:none;background:none;color:inherit}
::selection{background:rgba(255,154,60,.32)}

.container{width:100%;max-width:1200px;margin:0 auto;padding:0 24px}
section{scroll-margin-top:96px}

/* ============ SCROLLBAR ============ */
::-webkit-scrollbar{width:11px;height:11px}
::-webkit-scrollbar-track{background:#080B10}
::-webkit-scrollbar-thumb{background:#1D2735;border-radius:10px;border:3px solid #080B10}
::-webkit-scrollbar-thumb:hover{background:#2C3A4D}

/* ============ BOTÕES ============ */
.btn{
  display:inline-flex;align-items:center;justify-content:center;gap:9px;
  padding:13px 24px;border-radius:12px;font-weight:600;font-size:.92rem;
  border:1px solid transparent;transition:all .22s cubic-bezier(.4,0,.2,1);
  white-space:nowrap;letter-spacing:-.01em;
}
.btn svg{width:16px;height:16px;flex:none}
.btn-primary{
  background:linear-gradient(135deg,var(--amber-3),var(--amber) 45%,var(--amber-2));
  color:#231202;
  box-shadow:0 10px 32px -12px rgba(255,140,60,.85), inset 0 1px 0 rgba(255,255,255,.35);
}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 16px 40px -12px rgba(255,140,60,1), inset 0 1px 0 rgba(255,255,255,.45)}
.btn-ghost{border-color:var(--line-strong);background:rgba(255,255,255,.03);color:var(--text)}
.btn-ghost:hover{background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.24);transform:translateY(-2px)}
.btn-sm{padding:9px 16px;font-size:.85rem;border-radius:10px}
.btn-block{width:100%}

/* ============ NAV ============ */
.nav{
  position:sticky;top:0;z-index:900;
  backdrop-filter:blur(18px) saturate(160%);
  -webkit-backdrop-filter:blur(18px) saturate(160%);
  background:rgba(7,10,15,.72);
  border-bottom:1px solid transparent;
  transition:border-color .3s,background .3s;
}
.nav.scrolled{border-bottom-color:var(--line);background:rgba(7,10,15,.9)}
.nav-inner{display:flex;align-items:center;gap:28px;height:72px}

.brand{display:flex;align-items:center;gap:11px;flex:none}
.brand-logo{
  width:40px;height:40px;border-radius:12px;flex:none;
  background:linear-gradient(150deg,rgba(255,154,60,.16),rgba(255,107,53,.06));
  border:1px solid rgba(255,154,60,.25);
  display:grid;place-items:center;
  box-shadow:0 0 26px -8px rgba(255,154,60,.6);
  transition:transform .3s;
}
.brand:hover .brand-logo{transform:rotate(-8deg) scale(1.06)}
.brand-logo svg{width:27px;height:27px}
.brand-name{font-weight:800;font-size:1.2rem;letter-spacing:-.03em}
.brand-name .accent{color:var(--amber)}
.brand-sub{
  display:block;font-size:.6rem;font-weight:600;letter-spacing:.22em;
  color:var(--muted);text-transform:uppercase;margin-top:-6px
}

.nav-links{display:flex;align-items:center;gap:4px;margin-left:8px}
.nav-link{
  display:inline-flex;align-items:center;gap:6px;
  padding:9px 14px;border-radius:10px;font-size:.9rem;font-weight:500;
  color:#B9C4D4;transition:.2s;position:relative;
}
.nav-link:hover{color:#fff;background:rgba(255,255,255,.05)}
.nav-link.active{color:#fff}
.nav-link.active::after{
  content:"";position:absolute;left:14px;right:14px;bottom:2px;height:2px;
  background:linear-gradient(90deg,var(--amber),var(--amber-2));border-radius:2px;
}
.nav-link .chev{width:13px;height:13px;transition:transform .25s;opacity:.7}
.has-dropdown{position:relative}
.has-dropdown:hover .chev{transform:rotate(180deg)}

.dropdown{
  position:absolute;top:calc(100% + 10px);left:50%;transform:translateX(-50%) translateY(8px);
  width:340px;padding:8px;border-radius:18px;
  background:rgba(15,22,32,.97);
  border:1px solid var(--line-strong);
  box-shadow:0 30px 70px -20px rgba(0,0,0,.95);
  opacity:0;visibility:hidden;transition:.24s cubic-bezier(.4,0,.2,1);
  backdrop-filter:blur(20px);
}
.dropdown::before{
  content:"";position:absolute;top:-12px;left:0;right:0;height:12px;
}
.has-dropdown:hover .dropdown{opacity:1;visibility:visible;transform:translateX(-50%) translateY(0)}
.drop-item{
  display:flex;gap:13px;padding:12px;border-radius:12px;transition:.2s;
}
.drop-item:hover{background:rgba(255,255,255,.055)}
.drop-ico{
  width:38px;height:38px;border-radius:11px;flex:none;display:grid;place-items:center;
  font-size:1.05rem;border:1px solid var(--line);
}
.drop-ico.amber{background:linear-gradient(140deg,rgba(255,154,60,.22),rgba(255,107,53,.06));border-color:rgba(255,154,60,.3)}
.drop-ico.violet{background:linear-gradient(140deg,rgba(139,123,255,.22),rgba(139,123,255,.05));border-color:rgba(139,123,255,.3)}
.drop-ico.green{background:linear-gradient(140deg,rgba(61,220,151,.2),rgba(61,220,151,.05));border-color:rgba(61,220,151,.28)}
.drop-item strong{display:block;font-size:.9rem;font-weight:600;color:#fff;line-height:1.3}
.drop-item small{display:block;font-size:.76rem;color:var(--muted);line-height:1.4;margin-top:2px}

.nav-actions{display:flex;align-items:center;gap:10px;margin-left:auto}
.burger{
  display:none;width:42px;height:42px;border-radius:11px;
  border:1px solid var(--line-strong);background:rgba(255,255,255,.03);
  place-items:center;
}
.burger span{display:block;width:17px;height:2px;background:#D6DEEA;border-radius:2px;position:relative;transition:.3s}
.burger span::before,.burger span::after{
  content:"";position:absolute;left:0;width:17px;height:2px;background:#D6DEEA;border-radius:2px;transition:.3s;
}
.burger span::before{top:-5.5px}
.burger span::after{top:5.5px}
.burger.open span{background:transparent}
.burger.open span::before{top:0;transform:rotate(45deg)}
.burger.open span::after{top:0;transform:rotate(-45deg)}

/* ============ HERO ============ */
.hero{padding:82px 0 90px;position:relative;overflow:hidden}
.hero-grid{display:grid;grid-template-columns:1.05fr .95fr;gap:64px;align-items:start}
.hero-visual{
  align-self:start;
  margin-top:-8px;   /* ajusta conforme gostares */
}
.hero-terminal-bar{
  margin-bottom:14px;   /* era este — podes baixar para 8px */
}

.pill{
  display:inline-flex;align-items:center;gap:9px;
  padding:7px 15px 7px 8px;border-radius:100px;
  background:rgba(255,154,60,.09);border:1px solid rgba(255,154,60,.25);
  font-size:.79rem;font-weight:600;color:#FFCF9A;letter-spacing:.01em;
}
.pill .tag{
  background:linear-gradient(135deg,var(--amber),var(--amber-2));color:#231202;
  padding:2px 9px;border-radius:100px;font-size:.68rem;font-weight:800;letter-spacing:.04em;
}
.pulse-dot{
  width:7px;height:7px;border-radius:50%;background:var(--green);
  box-shadow:0 0 0 0 rgba(61,220,151,.7);animation:pulse 2.2s infinite;
}
@keyframes pulse{
  0%{box-shadow:0 0 0 0 rgba(61,220,151,.6)}
  70%{box-shadow:0 0 0 9px rgba(61,220,151,0)}
  100%{box-shadow:0 0 0 0 rgba(61,220,151,0)}
}

.hero h1{
  font-size:clamp(2.4rem,5.2vw,4.05rem);
  line-height:1.04;letter-spacing:-.045em;font-weight:800;
  margin:22px 0 20px;
}
.hero h1 .grad{
  background:linear-gradient(115deg,var(--amber-3) 5%,var(--amber) 40%,var(--amber-2) 78%);
  -webkit-background-clip:text;background-clip:text;color:transparent;
}
.hero h1 .stroke{
  -webkit-text-stroke:1.5px rgba(255,255,255,.42);
  color:transparent;
}
.hero p.lead{font-size:1.09rem;color:#A2B0C2;max-width:545px;margin-bottom:34px}
.hero p.lead strong{color:#E8EEF6;font-weight:600}

.community-tag{
  display:inline-flex;align-items:center;gap:8px;
  margin-bottom:22px;padding:6px 14px 6px 10px;border-radius:100px;
  font-size:.78rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;
  color:#9FE9C8;background:rgba(61,220,151,.08);
  border:1px solid rgba(61,220,151,.24);
}
.community-tag svg{width:14px;height:14px;flex:none}

.hero-cta{display:flex;flex-wrap:wrap;gap:13px;margin-bottom:34px}

.hero-meta{display:flex;flex-wrap:wrap;gap:26px;align-items:center}
.meta-item{display:flex;flex-direction:column}
.meta-item b{font-size:1.35rem;font-weight:800;letter-spacing:-.03em;
  background:linear-gradient(135deg,#fff,#9FB0C6);-webkit-background-clip:text;background-clip:text;color:transparent}
.meta-item span{font-size:.76rem;color:var(--muted);font-weight:500;letter-spacing:.02em}
.meta-sep{width:1px;height:34px;background:var(--line-strong)}

.code-window{
  border-radius:18px;overflow:hidden;
  background:linear-gradient(180deg,#0E1520,#0A0F16);
  border:1px solid var(--line-strong);
  box-shadow:0 40px 90px -30px rgba(0,0,0,.95), 0 0 0 1px rgba(255,255,255,.02) inset;
  position:relative;
}
.code-window::after{
  content:"";position:absolute;inset:0;border-radius:18px;pointer-events:none;
  background:linear-gradient(140deg,rgba(255,154,60,.09),transparent 42%);
}
.code-bar{
  display:flex;align-items:center;gap:12px;padding:12px 16px;
  background:rgba(255,255,255,.025);border-bottom:1px solid var(--line);
}
.dots{display:flex;gap:7px}
.dots i{width:11px;height:11px;border-radius:50%;display:block}
.dots i:nth-child(1){background:#FF5F57}
.dots i:nth-child(2){background:#FEBC2E}
.dots i:nth-child(3){background:#28C840}
.code-title{
  font-family:'JetBrains Mono',monospace;font-size:.74rem;color:var(--muted);
  margin:0 auto;letter-spacing:.03em;
}
.code-tabs{display:flex;gap:4px;padding:10px 12px 0;background:rgba(255,255,255,.012)}
.code-tab{
  font-family:'JetBrains Mono',monospace;font-size:.76rem;padding:8px 14px;
  border-radius:9px 9px 0 0;color:var(--muted);transition:.2s;border:1px solid transparent;border-bottom:none;
}
.code-tab:hover{color:#C8D3E2}
.code-tab.active{
  color:var(--amber);background:#0A0F16;
  border-color:var(--line-strong);border-bottom-color:#0A0F16;
}

.code-body{
  display: grid;
  grid-template-columns: 1fr;
  grid-template-rows: 1fr;
  min-height: 320px;
  font-family:'JetBrains Mono',monospace;
  font-size:.67rem;
  line-height:1.7;
  padding:16px 20px 20px;
  overflow-x:auto;
}
.code-pane{
  grid-area: 1 / 1;
  opacity: 0;
  visibility: hidden;
  pointer-events: none;
  transition: opacity .25s ease;
}
.code-pane.active{
  opacity: 1;
  visibility: visible;
  pointer-events: auto;
}

@keyframes fadeIn{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:none}}
.code-body .ln{display:block;white-space:pre}
.c-cmd{color:var(--green)}
.c-flag{color:#7FB2FF}
.c-str{color:#FFC46B}
.c-kw{color:#FF7EB6}
.c-fn{color:#8B7BFF}
.c-cm{color:#4E5D70;font-style:italic}
.c-var{color:#7FE3C4}
.c-out{color:#5F7085}
.cursor{
  display:inline-block;width:8px;height:15px;background:var(--amber);
  vertical-align:-2px;animation:blink 1.05s steps(2) infinite;border-radius:1px;
}
@keyframes blink{0%,49%{opacity:1}50%,100%{opacity:0}}

.float-card{
  position:absolute;right:-14px;bottom:-26px;
  background:rgba(15,22,32,.96);border:1px solid var(--line-strong);
  border-radius:14px;padding:13px 17px;backdrop-filter:blur(14px);
  box-shadow:0 24px 50px -18px rgba(0,0,0,.9);
  display:flex;align-items:center;gap:12px;
  animation:floaty 5.5s ease-in-out infinite;
}
@keyframes floaty{0%,100%{transform:translateY(0)}50%{transform:translateY(-11px)}}
.float-card .fc-ico{
  width:36px;height:36px;border-radius:10px;display:grid;place-items:center;
  background:linear-gradient(140deg,rgba(61,220,151,.2),rgba(61,220,151,.05));
  border:1px solid rgba(61,220,151,.28);font-size:1rem;
}
.float-card b{font-size:.83rem;font-weight:700;display:block;line-height:1.2}
.float-card span{font-size:.72rem;color:var(--muted)}

.hero-visual{position:relative}

/* ============ LOGOS / TRUST ============ */
.trust{padding:14px 0 60px}
.trust-label{
  text-align:center;font-size:.72rem;letter-spacing:.24em;text-transform:uppercase;
  color:#5D6B7E;font-weight:600;margin-bottom:26px;
}
.trust-row{
  display:flex;flex-wrap:wrap;justify-content:center;gap:16px 46px;align-items:center;
  opacity:.62;
}
.trust-row span{
  font-weight:700;font-size:1.02rem;letter-spacing:-.02em;color:#8FA0B5;
  display:flex;align-items:center;gap:8px;
}

/* ============ SECTION HEAD ============ */
.sec{padding:96px 0}
.sec-head{max-width:660px;margin-bottom:56px}
.sec-head.center{margin-left:auto;margin-right:auto;text-align:center}
.eyebrow{
  display:inline-flex;align-items:center;gap:8px;
  font-size:.75rem;font-weight:700;letter-spacing:.18em;text-transform:uppercase;
  color:var(--amber);margin-bottom:16px;
}
.eyebrow::before{content:"";width:22px;height:1.5px;background:linear-gradient(90deg,var(--amber),transparent)}
.sec-head.center .eyebrow::before{display:none}
.sec-head h2{
  font-size:clamp(1.85rem,3.6vw,2.7rem);line-height:1.12;
  letter-spacing:-.038em;font-weight:800;margin-bottom:16px;
}
.sec-head p{color:#95A3B6;font-size:1.02rem}

/* ============ FEATURES ============ */
.feat-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
.feat{
  padding:28px 26px 30px;border-radius:var(--radius);
  background:linear-gradient(180deg,rgba(255,255,255,.032),rgba(255,255,255,.008));
  border:1px solid var(--line);position:relative;overflow:hidden;
  transition:.3s cubic-bezier(.4,0,.2,1);
}
.feat::before{
  content:"";position:absolute;top:0;left:22px;right:22px;height:1px;
  background:linear-gradient(90deg,transparent,rgba(255,154,60,.55),transparent);
  opacity:0;transition:.3s;
}
.feat:hover{transform:translateY(-5px);border-color:var(--line-strong);background:linear-gradient(180deg,rgba(255,255,255,.055),rgba(255,255,255,.012))}
.feat:hover::before{opacity:1}
.feat-ico{
  width:46px;height:46px;border-radius:13px;display:grid;place-items:center;
  margin-bottom:19px;font-size:1.25rem;
  background:linear-gradient(140deg,rgba(255,154,60,.18),rgba(255,107,53,.04));
  border:1px solid rgba(255,154,60,.22);
}
.feat:nth-child(2) .feat-ico{background:linear-gradient(140deg,rgba(139,123,255,.18),rgba(139,123,255,.04));border-color:rgba(139,123,255,.24)}
.feat:nth-child(3) .feat-ico{background:linear-gradient(140deg,rgba(61,220,151,.18),rgba(61,220,151,.04));border-color:rgba(61,220,151,.24)}
.feat:nth-child(4) .feat-ico{background:linear-gradient(140deg,rgba(96,165,250,.18),rgba(96,165,250,.04));border-color:rgba(96,165,250,.24)}
.feat:nth-child(5) .feat-ico{background:linear-gradient(140deg,rgba(255,126,182,.18),rgba(255,126,182,.04));border-color:rgba(255,126,182,.24)}
.feat:nth-child(6) .feat-ico{background:linear-gradient(140deg,rgba(255,196,107,.18),rgba(255,196,107,.04));border-color:rgba(255,196,107,.24)}
.feat h3{font-size:1.06rem;font-weight:700;letter-spacing:-.02em;margin-bottom:9px}
.feat p{font-size:.9rem;color:#8C9AAC;line-height:1.65}
.feat code{
  font-family:'JetBrains Mono',monospace;font-size:.82em;
  background:rgba(255,154,60,.11);color:#FFC98F;padding:2px 6px;border-radius:5px;
  border:1px solid rgba(255,154,60,.16);
}

/* ============ SPLIT / SHOWCASE ============ */
.split{display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center}
.split.rev .split-media{order:-1}
.check-list{list-style:none;margin-top:26px;display:grid;gap:14px}
.check-list li{display:flex;gap:12px;align-items:flex-start;font-size:.94rem;color:#A9B6C7}
.check-ico{
  width:22px;height:22px;border-radius:7px;flex:none;margin-top:2px;
  display:grid;place-items:center;
  background:linear-gradient(140deg,rgba(61,220,151,.22),rgba(61,220,151,.05));
  border:1px solid rgba(61,220,151,.3);
}
.check-ico svg{width:12px;height:12px;stroke:var(--green);stroke-width:3;fill:none}

.stat-strip{
  display:grid;grid-template-columns:repeat(3,1fr);gap:1px;
  background:var(--line);border:1px solid var(--line);border-radius:16px;overflow:hidden;
  margin-top:56px;
}
.stat{background:#0B1119;padding:26px 22px;text-align:center;transition:.25s}
.stat:hover{background:#0F1723}
.stat b{
  display:block;font-size:1.95rem;font-weight:800;letter-spacing:-.04em;
  background:linear-gradient(135deg,var(--amber-3),var(--amber-2));
  -webkit-background-clip:text;background-clip:text;color:transparent;
}
.stat span{font-size:.79rem;color:var(--muted);font-weight:500}

/* ============ PRODUTOS ============ */
.prod-grid{display:grid;grid-template-columns:1fr 1fr;gap:22px}
.prod{
  border-radius:22px;padding:36px 34px 34px;position:relative;overflow:hidden;
  border:1px solid var(--line);background:linear-gradient(165deg,#111823,#0B1119);
  transition:.35s cubic-bezier(.4,0,.2,1);
}
.prod::after{
  content:"";position:absolute;width:340px;height:340px;border-radius:50%;
  right:-130px;top:-150px;filter:blur(70px);opacity:.4;transition:.4s;
}
.prod.sql::after{background:radial-gradient(circle,rgba(255,154,60,.6),transparent 68%)}
.prod.fra::after{background:radial-gradient(circle,rgba(139,123,255,.6),transparent 68%)}
.prod:hover{transform:translateY(-6px);border-color:var(--line-strong);box-shadow:var(--shadow)}
.prod:hover::after{opacity:.62}
.prod-head{display:flex;align-items:center;gap:15px;margin-bottom:22px;position:relative;z-index:1}
.prod-logo{
  width:56px;height:56px;border-radius:16px;display:grid;place-items:center;flex:none;
  font-size:1.5rem;border:1px solid var(--line-strong);
  background:rgba(255,255,255,.04);
}
.prod.sql .prod-logo{background:linear-gradient(145deg,rgba(255,154,60,.24),rgba(255,107,53,.06));border-color:rgba(255,154,60,.32)}
.prod.fra .prod-logo{background:linear-gradient(145deg,rgba(139,123,255,.24),rgba(139,123,255,.06));border-color:rgba(139,123,255,.32)}
.prod-head h3{font-size:1.4rem;font-weight:800;letter-spacing:-.03em;line-height:1.15}
.prod-head small{font-size:.79rem;color:var(--muted);font-weight:500;letter-spacing:.02em}
.prod > p{color:#93A1B4;font-size:.94rem;margin-bottom:24px;position:relative;z-index:1}
.prod-tags{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:28px;position:relative;z-index:1}
.tag-chip{
  font-size:.74rem;font-weight:600;padding:5px 11px;border-radius:8px;
  background:rgba(255,255,255,.045);border:1px solid var(--line);color:#9EACBE;
}
.prod-actions{display:flex;gap:11px;flex-wrap:wrap;position:relative;z-index:1}

/* ============ LOJA ============ */
.store-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px}
.product{
  border-radius:18px;overflow:hidden;border:1px solid var(--line);
  background:linear-gradient(180deg,#0F1620,#0A0F16);
  transition:.3s cubic-bezier(.4,0,.2,1);display:flex;flex-direction:column;
}
.product:hover{transform:translateY(-6px);border-color:var(--line-strong);box-shadow:var(--shadow)}
.product-thumb{
  height:132px;display:grid;place-items:center;font-size:2.3rem;
  border-bottom:1px solid var(--line);position:relative;overflow:hidden;
}
.product:nth-child(1) .product-thumb{background:linear-gradient(150deg,rgba(255,154,60,.2),rgba(255,107,53,.03))}
.product:nth-child(2) .product-thumb{background:linear-gradient(150deg,rgba(139,123,255,.2),rgba(139,123,255,.03))}
.product:nth-child(3) .product-thumb{background:linear-gradient(150deg,rgba(61,220,151,.2),rgba(61,220,151,.03))}
.product:nth-child(4) .product-thumb{background:linear-gradient(150deg,rgba(96,165,250,.2),rgba(96,165,250,.03))}
.product-thumb::after{
  content:"";position:absolute;inset:0;
  background-image:linear-gradient(rgba(255,255,255,.045) 1px,transparent 1px),
                   linear-gradient(90deg,rgba(255,255,255,.045) 1px,transparent 1px);
  background-size:22px 22px;opacity:.5;
}
.product-thumb span{position:relative;z-index:1;filter:drop-shadow(0 8px 18px rgba(0,0,0,.6))}
.badge-off{
  position:absolute;top:12px;right:12px;z-index:2;
  background:linear-gradient(135deg,var(--amber),var(--amber-2));color:#231202;
  font-size:.67rem;font-weight:800;padding:4px 9px;border-radius:7px;letter-spacing:.03em;
}
.product-body{padding:20px;display:flex;flex-direction:column;flex:1}
.product-body h4{font-size:.98rem;font-weight:700;letter-spacing:-.02em;margin-bottom:6px;line-height:1.3}
.product-body p{font-size:.82rem;color:var(--muted);margin-bottom:18px;flex:1;line-height:1.6}
.price{display:flex;align-items:baseline;gap:8px;margin-bottom:15px}
.price b{font-size:1.42rem;font-weight:800;letter-spacing:-.04em}
.price s{font-size:.82rem;color:#5F6D80}
.price em{font-size:.76rem;color:var(--muted);font-style:normal}

/* ============ CTA ============ */
.cta-band{
  border-radius:26px;padding:64px 52px;text-align:center;position:relative;overflow:hidden;
  background:linear-gradient(150deg,#131B27,#0A0F16 70%);
  border:1px solid var(--line-strong);
}
.cta-band::before{
  content:"";position:absolute;width:600px;height:600px;border-radius:50%;
  left:50%;top:-340px;transform:translateX(-50%);
  background:radial-gradient(circle,rgba(255,154,60,.3),transparent 65%);
  filter:blur(50px);
}
.cta-band > *{position:relative;z-index:1}
.cta-band h2{font-size:clamp(1.8rem,3.4vw,2.5rem);font-weight:800;letter-spacing:-.04em;margin-bottom:16px;line-height:1.14}
.cta-band p{color:#9AA8BB;max-width:520px;margin:0 auto 34px;font-size:1.02rem}
.cta-actions{display:flex;gap:13px;justify-content:center;flex-wrap:wrap}

/* ============ FOOTER ============ */
footer{border-top:1px solid var(--line);margin-top:100px;padding:64px 0 34px;background:rgba(5,8,12,.6);transition:background .3s}
.foot-grid{display:grid;grid-template-columns:1.6fr 1fr 1fr 1fr;gap:48px;margin-bottom:52px}
.foot-brand p{color:var(--muted);font-size:.88rem;margin:18px 0 22px;max-width:290px}
.socials{display:flex;gap:10px}
.social{
  width:38px;height:38px;border-radius:11px;display:grid;place-items:center;
  border:1px solid var(--line);background:rgba(255,255,255,.028);transition:.22s;
  color:#93A1B4;
}
.social:hover{border-color:rgba(255,154,60,.4);color:var(--amber);transform:translateY(-3px);background:rgba(255,154,60,.09)}
.social svg{width:17px;height:17px;fill:currentColor}
.foot-col h5{
  font-size:.76rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;
  color:#5F6D80;margin-bottom:18px;
}
.foot-col ul{list-style:none;display:grid;gap:11px}
.foot-col a{font-size:.88rem;color:#96A3B5;transition:.2s}
.foot-col a:hover{color:var(--amber);padding-left:3px}
.foot-bottom{
  border-top:1px solid var(--line);padding-top:26px;
  display:flex;justify-content:space-between;align-items:center;gap:20px;flex-wrap:wrap;
  font-size:.82rem;color:#5F6D80;
}
.foot-bottom .made{display:flex;align-items:center;gap:7px}

/* ============ MODAIS ============ */
.overlay{
  position:fixed;inset:0;z-index:1000;
  background:rgba(3,6,10,.78);backdrop-filter:blur(9px);-webkit-backdrop-filter:blur(9px);
  display:grid;place-items:center;padding:22px;
  opacity:0;visibility:hidden;transition:.28s ease;
}
.overlay.open{opacity:1;visibility:visible}
.modal{
  width:100%;max-width:450px;border-radius:22px;position:relative;
  background:linear-gradient(175deg,#131B26,#0C121A);
  border:1px solid var(--line-strong);
  box-shadow:0 50px 110px -30px rgba(0,0,0,.98);
  padding:34px 32px 30px;
  transform:translateY(22px) scale(.96);opacity:0;transition:.34s cubic-bezier(.34,1.3,.64,1);
  max-height:92vh;overflow-y:auto;
}
.overlay.open .modal{transform:translateY(0) scale(1);opacity:1}
.modal::before{
  content:"";position:absolute;top:0;left:34px;right:34px;height:1px;
  background:linear-gradient(90deg,transparent,rgba(255,154,60,.6),transparent);
}
.modal-close{
  position:absolute;top:16px;right:16px;width:34px;height:34px;border-radius:10px;
  display:grid;place-items:center;color:#7E8CA0;transition:.2s;
  border:1px solid transparent;
}
.modal-close:hover{background:rgba(255,255,255,.07);color:#fff;border-color:var(--line)}
.modal-close svg{width:15px;height:15px;stroke:currentColor;stroke-width:2.4;fill:none;stroke-linecap:round}
.modal-head{text-align:center;margin-bottom:26px}
.modal-ico{
  width:58px;height:58px;border-radius:17px;margin:0 auto 17px;display:grid;place-items:center;
  font-size:1.55rem;
  background:linear-gradient(145deg,rgba(255,154,60,.2),rgba(255,107,53,.05));
  border:1px solid rgba(255,154,60,.28);
}
.modal-ico.ok{background:linear-gradient(145deg,rgba(61,220,151,.2),rgba(61,220,151,.05));border-color:rgba(61,220,151,.3)}
.modal-ico.warn{background:linear-gradient(145deg,rgba(255,196,107,.2),rgba(255,196,107,.05));border-color:rgba(255,196,107,.3)}
.modal-head h3{font-size:1.32rem;font-weight:800;letter-spacing:-.03em;margin-bottom:7px}
.modal-head p{font-size:.88rem;color:var(--muted)}

.field{margin-bottom:15px}
.field label{
  display:block;font-size:.79rem;font-weight:600;color:#A7B4C6;
  margin-bottom:7px;letter-spacing:.01em;
}
.field input{
  width:100%;padding:12px 15px;border-radius:11px;font-size:.9rem;font-family:inherit;
  background:rgba(255,255,255,.035);border:1px solid var(--line-strong);
  color:var(--text);transition:.2s;outline:none;
}
.field input::placeholder{color:#5A6879}
.field input:focus{
  border-color:rgba(255,154,60,.6);background:rgba(255,154,60,.055);
  box-shadow:0 0 0 4px rgba(255,154,60,.11);
}
.field-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.modal-alt{
  text-align:center;font-size:.85rem;color:var(--muted);margin-top:20px;
}
.modal-alt button{color:var(--amber);font-weight:600;font-size:.85rem}
.modal-alt button:hover{text-decoration:underline}
.modal-note{
  display:flex;gap:9px;align-items:flex-start;font-size:.78rem;color:#6E7C8F;
  margin-top:18px;line-height:1.55;padding:12px 14px;border-radius:11px;
  background:rgba(255,255,255,.025);border:1px solid var(--line);
}
.modal-note svg{width:14px;height:14px;flex:none;margin-top:2px;stroke:var(--amber);stroke-width:2;fill:none}
.divider{
  display:flex;align-items:center;gap:14px;margin:20px 0;color:#4F5D6F;font-size:.76rem;
}
.divider::before,.divider::after{content:"";flex:1;height:1px;background:var(--line)}

/* ============ REVEAL ============ */
.reveal{opacity:0;transform:translateY(26px);transition:opacity .7s cubic-bezier(.4,0,.2,1),transform .7s cubic-bezier(.4,0,.2,1)}
.reveal.in{opacity:1;transform:none}

/* ============ DESIGN TOGGLE (header) ============ */
.design-toggle{position:relative;display:inline-flex}
.design-btn{
  display:inline-flex;align-items:center;gap:8px;
  height:36px;padding:0 12px;border-radius:11px;
  border:1px solid var(--line-strong);
  background:rgba(255,255,255,.03);
  color:var(--text);
  font-size:.82rem;font-weight:600;letter-spacing:-.01em;
  transition:.2s;
}
.design-btn:hover{border-color:rgba(255,154,60,.45);color:var(--amber)}
.design-btn .sw{
  width:14px;height:14px;border-radius:50%;
  border:1px solid rgba(255,255,255,.35);
  background:linear-gradient(135deg,#0F1620,#070A0F);
  flex:none;transition:.2s;
}
[data-design="amber"] .design-btn .sw{
  border-color:rgba(26,18,8,.3);
  background:linear-gradient(135deg,#F59E0B,#C2410C);
}
.design-btn svg{width:12px;height:12px;opacity:.7}
.design-menu{
  position:absolute;top:calc(100% + 8px);right:0;
  min-width:170px;padding:6px;border-radius:14px;
  background:rgba(15,22,32,.98);
  border:1px solid var(--line-strong);
  box-shadow:0 24px 50px -20px rgba(0,0,0,.95);
  opacity:0;visibility:hidden;transform:translateY(-4px);
  transition:.2s;z-index:50;
}
.design-toggle.open .design-menu{opacity:1;visibility:visible;transform:none}
.design-opt{
  display:flex;align-items:center;gap:10px;width:100%;
  padding:9px 11px;border-radius:9px;
  font-size:.85rem;font-weight:600;color:var(--text);
  transition:.15s;text-align:left;
}
.design-opt:hover{background:rgba(255,255,255,.06)}
.design-opt .sw{
  width:18px;height:18px;border-radius:50%;flex:none;
  border:1px solid rgba(255,255,255,.25);
}
.design-opt[data-design-val="black"] .sw{
  background:linear-gradient(135deg,#0F1620,#070A0F);
}
.design-opt[data-design-val="amber"] .sw{
  background:linear-gradient(135deg,#F59E0B,#C2410C);
  border-color:rgba(232,93,31,.5);
}
.design-opt .check{
  margin-left:auto;width:14px;height:14px;opacity:0;
  stroke:var(--amber);stroke-width:3;fill:none;
}
.design-opt.active .check{opacity:1}
[data-design="amber"] .design-menu{
  background:rgba(255,253,248,.98);
  border-color:rgba(26,18,8,.16);
}
[data-design="amber"] .design-opt:hover{background:rgba(26,18,8,.05)}

/* ============ DESIGN: ÂMBAR ============ */
[data-design="amber"]{
  --bg:#FBF6EE;
  --bg-2:#F6EFE2;
  --card:#FFFFFF;
  --card-2:#FBF6EE;
  --line:rgba(26,18,8,.10);
  --line-strong:rgba(26,18,8,.18);
  --text:#1A1208;
  --muted:#6B6B5F;
  --amber:#E85D1F;
  --amber-2:#C2410C;
  --amber-3:#F59E0B;
  --green:#15803D;
  --violet:#6D4AFF;
  --shadow:0 24px 60px -24px rgba(60,30,10,.28);
}
[data-design="amber"] body{background:var(--bg);color:var(--text)}
[data-design="amber"] body::before{
  background:
    radial-gradient(900px 500px at 12% -8%, rgba(245,158,11,.22), transparent 62%),
    radial-gradient(760px 460px at 88% 4%, rgba(109,74,255,.10), transparent 60%),
    radial-gradient(700px 500px at 50% 110%, rgba(232,93,31,.10), transparent 65%);
}
[data-design="amber"] body::after{
  background-image:
    linear-gradient(rgba(26,18,8,.045) 1px,transparent 1px),
    linear-gradient(90deg,rgba(26,18,8,.045) 1px,transparent 1px);
}
[data-design="amber"] ::selection{background:rgba(232,93,31,.25)}
[data-design="amber"] ::-webkit-scrollbar-track{background:#F1E9DA}
[data-design="amber"] ::-webkit-scrollbar-thumb{background:#D9CDB8;border-color:#F1E9DA}
[data-design="amber"] ::-webkit-scrollbar-thumb:hover{background:#C4B69E}

[data-design="amber"] .nav{background:rgba(251,246,238,.78)}
[data-design="amber"] .nav.scrolled{background:rgba(251,246,238,.94)}
[data-design="amber"] .nav-link{color:#4A3F2E}
[data-design="amber"] .nav-link:hover{color:#1A1208;background:rgba(26,18,8,.05)}
[data-design="amber"] .nav-link.active{color:#1A1208}
[data-design="amber"] .brand-sub{color:#8A7A5E}
[data-design="amber"] .brand-logo{
  background:linear-gradient(150deg,rgba(245,158,11,.22),rgba(232,93,31,.08));
  border-color:rgba(232,93,31,.30);
  box-shadow:0 0 26px -10px rgba(232,93,31,.55);
}

[data-design="amber"] .btn-primary{
  color:#FFF8EE;
  background:linear-gradient(135deg,#F59E0B,#E85D1F 50%,#C2410C);
  box-shadow:0 10px 32px -12px rgba(232,93,31,.7), inset 0 1px 0 rgba(255,255,255,.35);
}
[data-design="amber"] .btn-ghost{
  background:rgba(26,18,8,.04);
  border-color:rgba(26,18,8,.16);
  color:#2A1F12;
}
[data-design="amber"] .btn-ghost:hover{
  background:rgba(26,18,8,.08);
  border-color:rgba(26,18,8,.26);
}

[data-design="amber"] .pill{
  background:rgba(232,93,31,.10);
  border-color:rgba(232,93,31,.28);
  color:#8A3A12;
}
[data-design="amber"] .community-tag{
  background:rgba(21,128,61,.09);
  border-color:rgba(21,128,61,.26);
  color:#14532D;
}
[data-design="amber"] .hero h1 .stroke{-webkit-text-stroke:1.5px rgba(26,18,8,.35)}
[data-design="amber"] .hero p.lead{color:#5A4F3D}
[data-design="amber"] .hero p.lead strong{color:#1A1208}
[data-design="amber"] .meta-item b{
  background:linear-gradient(135deg,#1A1208,#6B5A3E);
  -webkit-background-clip:text;background-clip:text;color:transparent;
}
[data-design="amber"] .meta-item span{color:#7A6B52}
[data-design="amber"] .meta-sep{background:rgba(26,18,8,.16)}

[data-design="amber"] .code-window{
  background:linear-gradient(180deg,#FFFDF8,#FBF6EE);
  border-color:rgba(26,18,8,.14);
  box-shadow:0 40px 90px -30px rgba(90,60,20,.35), 0 0 0 1px rgba(255,255,255,.6) inset;
}
[data-design="amber"] .code-bar{
  background:rgba(26,18,8,.035);
  border-bottom-color:rgba(26,18,8,.10);
}
[data-design="amber"] .code-title{color:#7A6B52}
[data-design="amber"] .code-tabs{background:rgba(26,18,8,.02)}
[data-design="amber"] .code-tab{color:#7A6B52}
[data-design="amber"] .code-tab:hover{color:#2A1F12}
[data-design="amber"] .code-tab.active{
  color:#C2410C;background:#FBF6EE;
  border-color:rgba(26,18,8,.14);border-bottom-color:#FBF6EE;
}
[data-design="amber"] .code-body{color:#2A1F12}
[data-design="amber"] .c-cmd{color:#15803D}
[data-design="amber"] .c-flag{color:#2563EB}
[data-design="amber"] .c-str{color:#B45309}
[data-design="amber"] .c-kw{color:#BE185D}
[data-design="amber"] .c-fn{color:#6D4AFF}
[data-design="amber"] .c-cm{color:#9A8B70;font-style:italic}
[data-design="amber"] .c-var{color:#0F766E}
[data-design="amber"] .c-out{color:#8A7A5E}
[data-design="amber"] .cursor{background:#C2410C}

[data-design="amber"] .trust-label{color:#9A8B70}
[data-design="amber"] .trust-row span{color:#6B5A3E}

[data-design="amber"] .eyebrow{color:#C2410C}
[data-design="amber"] .sec-head p{color:#5A4F3D}

[data-design="amber"] .feat{
  background:linear-gradient(180deg,rgba(255,255,255,.9),rgba(255,255,255,.55));
  border-color:rgba(26,18,8,.10);
}
[data-design="amber"] .feat:hover{
  background:linear-gradient(180deg,#FFFFFF,rgba(255,255,255,.75));
  border-color:rgba(26,18,8,.18);
}
[data-design="amber"] .feat p{color:#5A4F3D}
[data-design="amber"] .feat code{
  background:rgba(232,93,31,.10);
  color:#8A3A12;
  border-color:rgba(232,93,31,.20);
}

[data-design="amber"] .check-list li{color:#4A3F2E}
[data-design="amber"] .check-ico{
  background:linear-gradient(140deg,rgba(21,128,61,.14),rgba(21,128,61,.04));
  border-color:rgba(21,128,61,.30);
}

[data-design="amber"] .stat-strip{
  background:rgba(26,18,8,.10);
  border-color:rgba(26,18,8,.10);
}
[data-design="amber"] .stat{background:#FFFDF8}
[data-design="amber"] .stat:hover{background:#FFFFFF}
[data-design="amber"] .stat b{
  background:linear-gradient(135deg,#F59E0B,#C2410C);
  -webkit-background-clip:text;background-clip:text;color:transparent;
}
[data-design="amber"] .stat span{color:#7A6B52}

[data-design="amber"] .prod{
  background:linear-gradient(165deg,#FFFFFF,#FBF6EE);
  border-color:rgba(26,18,8,.10);
}
[data-design="amber"] .prod:hover{border-color:rgba(26,18,8,.20)}
[data-design="amber"] .prod-head small{color:#7A6B52}
[data-design="amber"] .prod > p{color:#5A4F3D}
[data-design="amber"] .tag-chip{
  background:rgba(26,18,8,.045);
  border-color:rgba(26,18,8,.10);
  color:#6B5A3E;
}

[data-design="amber"] .product{
  background:linear-gradient(180deg,#FFFFFF,#FBF6EE);
  border-color:rgba(26,18,8,.10);
}
[data-design="amber"] .product-body p{color:#7A6B52}
[data-design="amber"] .price s{color:#A89A80}

[data-design="amber"] .cta-band{
  background:linear-gradient(150deg,#FFFFFF,#FBF6EE 70%);
  border-color:rgba(26,18,8,.14);
}
[data-design="amber"] .cta-band p{color:#5A4F3D}

[data-design="amber"] .float-card{
  background:rgba(255,253,248,.96);
  border-color:rgba(26,18,8,.14);
  box-shadow:0 24px 50px -18px rgba(90,60,20,.35);
}
[data-design="amber"] .float-card b{color:#1A1208}
[data-design="amber"] .float-card span{color:#7A6B52}

[data-design="amber"] footer{
  background:rgba(246,239,226,.7);
  border-top-color:rgba(26,18,8,.10);
}
[data-design="amber"] .foot-brand p{color:#7A6B52}
[data-design="amber"] .foot-col h5{color:#9A8B70}
[data-design="amber"] .foot-col a{color:#5A4F3D}
[data-design="amber"] .social{
  border-color:rgba(26,18,8,.12);
  background:rgba(26,18,8,.035);
  color:#5A4F3D;
}
[data-design="amber"] .foot-bottom{color:#9A8B70}

[data-design="amber"] .overlay{background:rgba(60,40,20,.45)}
[data-design="amber"] .modal{
  background:linear-gradient(175deg,#FFFFFF,#FBF6EE);
  border-color:rgba(26,18,8,.16);
}
[data-design="amber"] .modal-head p{color:#7A6B52}
[data-design="amber"] .field label{color:#4A3F2E}
[data-design="amber"] .field input{
  background:rgba(26,18,8,.035);
  border-color:rgba(26,18,8,.16);
  color:#1A1208;
}
[data-design="amber"] .field input::placeholder{color:#A89A80}
[data-design="amber"] .field input:focus{
  border-color:rgba(232,93,31,.55);
  background:rgba(232,93,31,.05);
  box-shadow:0 0 0 4px rgba(232,93,31,.12);
}
[data-design="amber"] .modal-note{
  background:rgba(26,18,8,.035);
  border-color:rgba(26,18,8,.10);
  color:#7A6B52;
}
[data-design="amber"] .modal-alt{color:#7A6B52}
[data-design="amber"] .modal-alt button{color:#C2410C}

[data-design="amber"] .dropdown{
  background:rgba(255,253,248,.98);
  border-color:rgba(26,18,8,.16);
}
[data-design="amber"] .drop-item strong{color:#1A1208}
[data-design="amber"] .drop-item small{color:#7A6B52}
[data-design="amber"] .drop-item:hover{background:rgba(26,18,8,.045)}

/* ============ RESPONSIVO ============ */
@media(max-width:1040px){
  .hero-grid{grid-template-columns:1fr;gap:52px}
  .hero-visual{max-width:620px}
  .feat-grid{grid-template-columns:repeat(2,1fr)}
  .store-grid{grid-template-columns:repeat(2,1fr)}
  .foot-grid{grid-template-columns:1fr 1fr;gap:36px}
  .split{grid-template-columns:1fr;gap:42px}
  .split.rev .split-media{order:0}
}
@media(max-width:860px){
  .nav-links{
    position:fixed;top:72px;left:0;right:0;
    flex-direction:column;align-items:stretch;gap:4px;
    background:rgba(9,13,19,.98);backdrop-filter:blur(22px);
    border-bottom:1px solid var(--line-strong);
    padding:16px 20px 24px;
    transform:translateY(-14px);opacity:0;visibility:hidden;transition:.28s;
    max-height:calc(100vh - 72px);overflow-y:auto;margin-left:0;
  }
  [data-design="amber"] .nav-links{background:rgba(251,246,238,.98)}
  .nav-links.open{transform:none;opacity:1;visibility:visible}
  .nav-link{padding:13px 14px;font-size:.96rem;border-radius:11px}
  .nav-link.active::after{display:none}
  .nav-link.active{background:rgba(255,154,60,.1);color:var(--amber)}
  .has-dropdown{position:static}
  .dropdown{
    position:static;transform:none;opacity:1;visibility:visible;width:100%;
    box-shadow:none;background:rgba(255,255,255,.025);margin-top:4px;padding:6px;
    display:none;
  }
  [data-design="amber"] .dropdown{background:rgba(26,18,8,.035)}
  .has-dropdown.open .dropdown{display:block}
  .burger{display:grid}
  .nav-actions .btn-ghost{display:none}
  .prod-grid{grid-template-columns:1fr}
  .cta-band{padding:48px 26px}
  .sec{padding:74px 0}
  .design-btn .lbl{display:none}
  .design-btn{padding:0 10px}
}
@media(max-width:620px){
  .feat-grid{grid-template-columns:1fr}
  .store-grid{grid-template-columns:1fr}
  .foot-grid{grid-template-columns:1fr;gap:32px}
  .stat-strip{grid-template-columns:1fr}
  .hero{padding:52px 0 70px}
  .hero-meta{gap:18px}
  .meta-sep{display:none}
  .float-card{right:0;bottom:-18px}
  .modal{padding:28px 22px 24px}
  .field-row{grid-template-columns:1fr}
  .foot-bottom{justify-content:center;text-align:center}
}

/* ============ BARRA ACIMA DO TERMINAL ============ */
.hero-terminal-bar{
  display:flex;
  align-items:center;
  justify-content:flex-end;
  gap:8px;
  margin-bottom:14px;
  flex-wrap:wrap;
}

.roar-pill{
  display:inline-flex;align-items:center;gap:8px;
  padding:6px 14px 6px 10px;border-radius:100px;
  background:rgba(255,154,60,.09);
  border:1px solid rgba(255,154,60,.25);
  font-size:.72rem;font-weight:600;
  color:#FFCF9A;letter-spacing:.01em;
  cursor:pointer;white-space:nowrap;
  transition:.2s;
}
.roar-pill:hover{
  background:rgba(255,154,60,.14);
  border-color:rgba(255,154,60,.4);
}
.roar-pill .pulse-dot{
  width:6px;height:6px;border-radius:50%;
  background:var(--green);
  box-shadow:0 0 0 0 rgba(61,220,151,.7);
  animation:pulse 2.2s infinite;
  flex:none;
}
[data-design="amber"] .roar-pill{
  background:rgba(232,93,31,.10);
  border-color:rgba(232,93,31,.28);
  color:#8A3A12;
}
[data-design="amber"] .roar-pill:hover{
  background:rgba(232,93,31,.16);
  border-color:rgba(232,93,31,.45);
}

.version-pill{
  display:inline-flex;align-items:center;gap:5px;
  padding:6px 12px;border-radius:100px;
  background:rgba(255,255,255,.03);
  border:1px solid var(--line-strong);
  font-family:'JetBrains Mono',monospace;
  font-size:.7rem;
  color:var(--muted);
  white-space:nowrap;
  line-height:1;
}
.version-pill b{
  color:var(--text);
  font-weight:700;
  letter-spacing:-.01em;
}
.version-pill .sep{
  opacity:.35;
  font-size:.75em;
  padding:0 1px;
}
.version-pill a{
  color:var(--amber);
  font-weight:700;
  transition:.15s;
}
.version-pill a:hover{
  color:var(--amber-3);
  text-decoration:underline;
}
[data-design="amber"] .version-pill{
  background:rgba(26,18,8,.035);
  border-color:rgba(26,18,8,.14);
  color:#7A6B52;
}
[data-design="amber"] .version-pill b{color:#1A1208}
[data-design="amber"] .version-pill a{color:#C2410C}
[data-design="amber"] .version-pill a:hover{color:#8A3A12}

@media(max-width:620px){
  .hero-terminal-bar{justify-content:flex-start}
  .roar-pill .roar-text{display:none}
  .roar-pill{padding:6px 10px}
}

/* ============ CHAT BEAVER ============ */
.chat-fab{
  position:fixed;right:24px;bottom:24px;z-index:950;
  width:56px;height:56px;border-radius:50%;
  display:grid;place-items:center;
  background:linear-gradient(135deg,var(--amber-3),var(--amber) 45%,var(--amber-2));
  color:#231202;
  box-shadow:0 12px 36px -10px rgba(255,140,60,.85), inset 0 1px 0 rgba(255,255,255,.35);
  transition:transform .22s cubic-bezier(.4,0,.2,1), box-shadow .22s;
}
.chat-fab:hover{transform:translateY(-3px) scale(1.05);box-shadow:0 18px 46px -10px rgba(255,140,60,1)}
.chat-fab svg{width:22px;height:22px}
.chat-fab-badge{
  position:absolute;top:-2px;right:-2px;
  min-width:20px;height:20px;padding:0 5px;border-radius:10px;
  background:#EF4444;color:#fff;
  font-size:.68rem;font-weight:800;
  display:grid;place-items:center;
  border:2px solid var(--bg);
  animation:pulse 2s infinite;
}
.chat-fab.hidden{transform:scale(0);opacity:0;pointer-events:none}

.chat-panel{
  position:fixed;right:24px;bottom:24px;z-index:960;
  width:min(380px, calc(100vw - 32px));
  max-height:min(560px, calc(100vh - 48px));
  display:flex;flex-direction:column;
  border-radius:20px;overflow:hidden;
  background:linear-gradient(180deg,#131B26,#0C121A);
  border:1px solid var(--line-strong);
  box-shadow:0 40px 90px -25px rgba(0,0,0,.95);
  opacity:0;visibility:hidden;transform:translateY(20px) scale(.96);
  transition:.3s cubic-bezier(.34,1.3,.64,1);
  transform-origin:bottom right;
}
.chat-panel.open{opacity:1;visibility:visible;transform:none}

.chat-head{
  display:flex;align-items:center;gap:12px;
  padding:14px 16px;
  background:rgba(255,255,255,.03);
  border-bottom:1px solid var(--line);
}
.chat-avatar{
  width:40px;height:40px;border-radius:12px;flex:none;
  display:grid;place-items:center;
  background:linear-gradient(150deg,rgba(255,154,60,.16),rgba(255,107,53,.06));
  border:1px solid rgba(255,154,60,.3);
}
.chat-avatar svg{width:26px;height:26px}
.chat-head-info{flex:1;display:flex;flex-direction:column;line-height:1.2}
.chat-head-info strong{font-size:.92rem;font-weight:700}
.chat-head-info small{
  font-size:.72rem;color:var(--muted);
  display:flex;align-items:center;gap:5px;margin-top:2px;
}
.chat-dot{
  width:7px;height:7px;border-radius:50%;background:var(--green);
  box-shadow:0 0 0 0 rgba(61,220,151,.6);
  animation:pulse 2.2s infinite;
}
.chat-close{
  width:32px;height:32px;border-radius:9px;
  display:grid;place-items:center;color:#7E8CA0;
  transition:.2s;
}
/* Botão voltar (mostra as perguntas rápidas) */
.chat-back{
  width:32px;height:32px;border-radius:9px;
  display:grid;place-items:center;color:#7E8CA0;
  transition:.2s;flex:none;
}
.chat-back:hover{background:rgba(255,255,255,.07);color:#fff}
.chat-back svg{width:15px;height:15px}
.chat-back[hidden]{display:none}

[data-design="amber"] .chat-back:hover{
  background:rgba(26,18,8,.06);
  color:#1A1208;
}
.chat-close:hover{background:rgba(255,255,255,.07);color:#fff}
.chat-close svg{width:15px;height:15px}

.chat-body{
  flex:1;overflow-y:auto;
  padding:16px;
  display:flex;flex-direction:column;gap:10px;
  scrollbar-width:thin;
}
.chat-body::-webkit-scrollbar{width:6px}
.chat-body::-webkit-scrollbar-thumb{background:rgba(255,255,255,.1);border-radius:6px}

.chat-msg{display:flex;gap:8px;align-items:flex-end;max-width:88%}
.chat-msg.bot{align-self:flex-start}
.chat-msg.user{align-self:flex-end;flex-direction:row-reverse}

.chat-bubble{
  padding:10px 14px;border-radius:14px;
  font-size:.87rem;line-height:1.5;
  background:rgba(255,255,255,.055);
  border:1px solid var(--line);
  color:var(--text);
  word-wrap:break-word;
}
.chat-msg.bot .chat-bubble{
  border-bottom-left-radius:4px;
  background:linear-gradient(140deg,rgba(255,154,60,.14),rgba(255,107,53,.05));
  border-color:rgba(255,154,60,.25);
}
.chat-msg.user .chat-bubble{
  border-bottom-right-radius:4px;
  background:linear-gradient(135deg,var(--amber-3),var(--amber) 45%,var(--amber-2));
  color:#231202;border-color:transparent;font-weight:500;
}

.chat-msg.typing .chat-bubble{
  display:flex;gap:4px;align-items:center;padding:12px 16px;
}
.chat-msg.typing .chat-bubble i{
  width:6px;height:6px;border-radius:50%;background:var(--muted);
  animation:chatTyping 1.2s infinite;
}
.chat-msg.typing .chat-bubble i:nth-child(2){animation-delay:.15s}
.chat-msg.typing .chat-bubble i:nth-child(3){animation-delay:.3s}
@keyframes chatTyping{
  0%,60%,100%{transform:translateY(0);opacity:.4}
  30%{transform:translateY(-4px);opacity:1}
}

.chat-quick{
  display:flex;flex-wrap:wrap;gap:6px;margin-top:6px;
}
.chat-quick button{
  font-size:.76rem;font-weight:600;
  padding:6px 11px;border-radius:99px;
  background:rgba(255,255,255,.04);
  border:1px solid var(--line-strong);
  color:var(--text);
  transition:.2s;
}
.chat-quick button:hover{
  border-color:rgba(255,154,60,.5);
  color:var(--amber);
  background:rgba(255,154,60,.08);
}

.chat-form{
  display:flex;gap:8px;padding:12px;
  border-top:1px solid var(--line);
  background:rgba(255,255,255,.02);
}
.chat-form input{
  flex:1;padding:10px 14px;border-radius:11px;
  background:rgba(255,255,255,.04);
  border:1px solid var(--line-strong);
  color:var(--text);
  font-size:.88rem;font-family:inherit;
  outline:none;transition:.2s;
}
.chat-form input::placeholder{color:#5A6879}
.chat-form input:focus{
  border-color:rgba(255,154,60,.6);
  background:rgba(255,154,60,.05);
  box-shadow:0 0 0 3px rgba(255,154,60,.12);
}
.chat-form button{
  width:40px;height:40px;border-radius:11px;flex:none;
  display:grid;place-items:center;
  background:linear-gradient(135deg,var(--amber-3),var(--amber) 45%,var(--amber-2));
  color:#231202;
  transition:.2s;
}
.chat-form button:hover{transform:translateY(-1px)}
.chat-form button svg{width:16px;height:16px}

/* Âmbar */
[data-design="amber"] .chat-panel{
  background:linear-gradient(180deg,#FFFFFF,#FBF6EE);
  border-color:rgba(26,18,8,.16);
  box-shadow:0 40px 90px -25px rgba(90,60,20,.35);
}
[data-design="amber"] .chat-head{
  background:rgba(26,18,8,.03);
  border-bottom-color:rgba(26,18,8,.10);
}
[data-design="amber"] .chat-head-info small{color:#7A6B52}
[data-design="amber"] .chat-close:hover{background:rgba(26,18,8,.06);color:#1A1208}
[data-design="amber"] .chat-body::-webkit-scrollbar-thumb{background:rgba(26,18,8,.15)}
[data-design="amber"] .chat-msg.bot .chat-bubble{
  background:linear-gradient(140deg,rgba(232,93,31,.10),rgba(232,93,31,.04));
  border-color:rgba(232,93,31,.22);
  color:#2A1F12;
}
[data-design="amber"] .chat-msg.user .chat-bubble{
  color:#FFF8EE;
  background:linear-gradient(135deg,#F59E0B,#E85D1F 50%,#C2410C);
}
[data-design="amber"] .chat-quick button{
  background:rgba(26,18,8,.035);
  border-color:rgba(26,18,8,.14);
  color:#4A3F2E;
}
[data-design="amber"] .chat-quick button:hover{
  border-color:rgba(232,93,31,.5);
  color:#C2410C;
  background:rgba(232,93,31,.08);
}
[data-design="amber"] .chat-form{
  background:rgba(26,18,8,.03);
  border-top-color:rgba(26,18,8,.10);
}
[data-design="amber"] .chat-form input{
  background:rgba(26,18,8,.035);
  border-color:rgba(26,18,8,.14);
  color:#1A1208;
}
[data-design="amber"] .chat-form input::placeholder{color:#A89A80}
[data-design="amber"] .chat-form input:focus{
  border-color:rgba(232,93,31,.5);
  background:rgba(232,93,31,.05);
  box-shadow:0 0 0 3px rgba(232,93,31,.12);
}
[data-design="amber"] .chat-fab-badge{border-color:#FBF6EE}

@media(max-width:620px){
  .chat-panel{
    right:12px;left:12px;bottom:12px;
    width:auto;max-height:calc(100vh - 24px);
  }
  .chat-fab{right:16px;bottom:16px}
  .chat-panel.open ~ .chat-fab,
  .chat-fab.hidden{display:none}
}

/* ============ TERMINAL SANDBOX ============ */
.terminal-window .code-bar{gap:12px}
.terminal-reset{
  width:26px;height:26px;border-radius:7px;
  display:grid;place-items:center;
  color:var(--muted);
  transition:.2s;flex:none;
}
.terminal-reset:hover{background:rgba(255,255,255,.06);color:var(--amber)}
.terminal-reset svg{width:13px;height:13px}
[data-design="amber"] .terminal-reset:hover{background:rgba(26,18,8,.06);color:#C2410C}

.terminal-body{
  display:block;
  min-height:320px;
  max-height:380px;
  overflow-y:auto;
  padding:16px 20px 20px;
  font-family:'JetBrains Mono',monospace;
  font-size:.67rem;
  line-height:1.7;
  color:var(--text);
  cursor:text;
  scrollbar-width:thin;
}
.terminal-body::-webkit-scrollbar{width:6px}
.terminal-body::-webkit-scrollbar-thumb{background:rgba(255,255,255,.1);border-radius:6px}
[data-design="amber"] .terminal-body::-webkit-scrollbar-thumb{background:rgba(26,18,8,.15)}

.term-line{display:block;white-space:pre-wrap;word-break:break-word}
.term-prompt{
  display:inline-flex;
  align-items:baseline;
  gap:8px;
  width:100%;
}
.term-prompt .term-user{
  color:var(--green);
  flex:none;
  user-select:none;
}
[data-design="amber"] .term-prompt .term-user{color:#15803D}

.term-input{
  flex:1;
  background:transparent;
  border:none;
  outline:none;
  color:inherit;
  font-family:inherit;
  font-size:inherit;
  line-height:inherit;
  padding:0;
  caret-color:var(--amber);
  min-width:0;
}
[data-design="amber"] .term-input{caret-color:#C2410C}

.term-cursor{
  display:inline-block;
  width:8px;height:15px;
  background:var(--amber);
  vertical-align:-2px;
  animation:blink 1.05s steps(2) infinite;
  border-radius:1px;
  margin-left:1px;
}
[data-design="amber"] .term-cursor{background:#C2410C}

.term-hint{
  color:var(--muted);
  opacity:.5;
  margin-left:2px;
}
[data-design="amber"] .term-hint{color:#7A6B52}

.term-caret{
  display:inline-block;
  width:8px;height:15px;
  background:var(--amber);
  vertical-align:-2px;
  margin-left:1px;
  border-radius:1px;
  animation:blink 1.05s steps(2) infinite;
}
[data-design="amber"] .term-caret{background:#C2410C}

.term-prompt .term-typed{
  white-space:pre;
}
</style>
</head>
<body>

<!-- ====== SVG SYMBOLS ====== -->
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
      <ellipse cx="32" cy="41" rx="15.5" ry="12" fill="#0A0E14" opacity=".2"/>
      <ellipse cx="32" cy="34.5" rx="4.6" ry="3.2" fill="#1A1208"/>
      <circle cx="22.5" cy="26" r="3.4" fill="#1A1208"/>
      <circle cx="41.5" cy="26" r="3.4" fill="#1A1208"/>
      <circle cx="23.6" cy="25" r="1.1" fill="#FFF6E8" opacity=".85"/>
      <circle cx="42.6" cy="25" r="1.1" fill="#FFF6E8" opacity=".85"/>
      <rect x="27.3" y="44.5" width="4.3" height="10.5" rx="1.7" fill="#FFF6E8"/>
      <rect x="32.4" y="44.5" width="4.3" height="10.5" rx="1.7" fill="#FFF6E8"/>
    </symbol>
  </defs>
</svg>

<!-- ====== NAV ====== -->
<header class="nav" id="nav">
  <div class="container nav-inner">
    <a href="#inicio" class="brand">
      <span class="brand-logo"><svg><use href="#beaver"/></svg></span>
      <span>
        <span class="brand-name">Beaver<span class="accent">.</span></span>
        <span class="brand-sub">Framework</span>
      </span>
    </a>

    <nav class="nav-links" id="navLinks">
      <a href="#inicio" class="nav-link active">Início</a>
      <a href="#framework" class="nav-link">Framework</a>

      <div class="has-dropdown" id="dropProd">
        <button class="nav-link" id="dropToggle">
          Produtos
          <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="dropdown">
          <a href="#produtos" class="drop-item">
            <span class="drop-ico amber">🗄️</span>
            <span><strong>SqlWizard</strong><small>Analise, otimize e monitore as suas queries em tempo real.</small></span>
          </a>
          <a href="#produtos" class="drop-item">
            <span class="drop-ico violet">🔑</span>
            <span><strong>Frankei Analyser:</strong><small>Analisa código contra XSS, SQL Injection, CSRF, SSRF, XXE, LFI/RFI, Command Injection, Path Traversal, Deserialização Insegura, Open Redirect e outras ameaças ...</small></span>
          </a>
          <a href="#loja" class="drop-item">
            <span class="drop-ico green">🛒</span>
            <span><strong>Loja Oficial</strong><small>Licenças, cursos, kits e merchandise oficial.</small></span>
          </a>
        </div>
      </div>

      <a href="#loja" class="nav-link">Loja</a>
      <div class="has-dropdown" id="dropDocs">
        <a href="/documentation" class="nav-link" id="dropDocsToggle">
          Documentação
          <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M6 9l6 6 6-6"/></svg>
        </a>
        <div class="dropdown">
          <a href="/documentation" class="drop-item">
            <span class="drop-ico amber">📘</span>
            <span><strong>Visão geral</strong><small>Referência dos componentes, classes e APIs do framework.</small></span>
          </a>
          <a href="/commands" class="drop-item">
            <span class="drop-ico violet">⌨️</span>
            <span><strong>Comandos CLI</strong><small>Criar, registar e correr comandos no Beaver.</small></span>
          </a>
          <a href="/manual" class="drop-item">
            <span class="drop-ico green">📖</span>
            <span><strong>Manual</strong><small>Guia passo-a-passo para começar e evoluir.</small></span>
          </a>
          <a href="/sdk" class="drop-item">
            <span class="drop-ico amber">🧩</span>
            <span><strong>SDK</strong><small>Contratos, hooks e estrutura para plugins.</small></span>
          </a>
          <a href="/pro" class="drop-item">
            <span class="drop-ico violet">⭐</span>
            <span><strong>Pro</strong><small>Funcionalidades pagas e suporte dedicado.</small></span>
          </a>
        </div>
      </div>
      <a href="#comunidade" class="nav-link">Comunidade</a>
    </nav>

    <div class="nav-actions">

    


      <!-- Design toggle -->
      <div class="design-toggle" id="designToggle">
        <button class="design-btn" id="designBtn" aria-haspopup="true" aria-expanded="false" title="Alterar design">
          <span class="sw"></span>
          <span class="lbl">Design</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="design-menu" role="menu">
          <button class="design-opt" data-design-val="black" role="menuitem">
            <span class="sw"></span> Black
            <svg class="check" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
          </button>
          <button class="design-opt" data-design-val="amber" role="menuitem">
            <span class="sw"></span> Âmbar
            <svg class="check" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
          </button>
        </div>
      </div>

      <button class="btn btn-ghost btn-sm" data-modal="modalLogin">Entrar</button>
      <button class="btn btn-primary btn-sm" data-modal="modalRegisto">Criar conta</button>
      <button class="burger" id="burger" aria-label="Menu"><span></span></button>
    </div>
  </div>
</header>

<main>

<!-- ====== HERO ====== -->
<section class="hero" id="inicio">
  <div class="container hero-grid">
   <div class="hero-copy">
  <div class="pill">
    <span class="tag">🦫</span>
    <span class="pulse-dot"></span>
    Estou a roer agora para finalizar esta barragem
  </div>

  <h1>
    Como o castor<br>
    <span class="grad">antecipe o risco, crie o habitat</span>
  </h1>

  <span class="community-tag">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
    A framework da comunidade
  </span>

  <p class="lead">
    O <strong>Beaver Framework</strong> é um framework PHP moderno, rápido e opinativo —
    construído pela comunidade, para a comunidade. Feito para quem quer entregar software
    sólido sem perder tempo com boilerplate. Convenção sobre configuração, com toda a
    flexibilidade que precisa.
  </p>

  <div class="hero-cta">
    <button class="btn btn-primary" data-modal="modalRegisto">
      Começar agora
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
    </button>
    <button class="btn btn-ghost" data-doc>
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
      Ler a documentação
    </button>
  </div>

  <div class="hero-meta">
    <div class="meta-item"><b>18k+</b><span>Instalações</span></div>
    <div class="meta-sep"></div>
    <div class="meta-item"><b>4.2k</b><span>Membros na comunidade</span></div>
    <div class="meta-sep"></div>
    <div class="meta-item"><b>2.4k</b><span>Estrelas GitHub</span></div>
    <div class="meta-sep"></div>
    <div class="meta-item"><b>MIT</b><span>Licença aberta</span></div>
  </div>
</div>

<div class="hero-visual reveal">

      <!-- Barra acima do terminal -->
      <div class="hero-terminal-bar">
        <div class="version-pill" aria-label="Versões e manual">
          <a href="/versions" title="Framework — ver todas as versões">Beaver <b>v<?= beaver_version() ?></b></a>
          <span class="sep">·</span>
          <a href="/versions#sdk" title="Plugin API — ver versões">SDK <b>v<?= beaver_api_version() ?></b></a>
          <span class="sep">·</span>
          <a href="/manual">Manual</a>
        </div>
      </div>

      <div class="code-window terminal-window" id="terminalWindow" role="region" aria-label="Terminal interativo do Beaver Framework">
        <div class="code-bar">
          <div class="dots" aria-hidden="true"><i></i><i></i><i></i></div>
          <div class="code-title" id="termTitle">beaver — terminal</div>
          <button class="terminal-reset" id="termReset" type="button" title="Limpar terminal" aria-label="Limpar terminal">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
              <path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5"/>
            </svg>
          </button>
        </div>

        <div class="code-tabs" role="tablist" aria-label="Vistas do terminal">
          <button class="code-tab active" type="button" role="tab" aria-selected="true" data-tab="t1" id="tab-terminal" aria-controls="t1">terminal</button>
          <button class="code-tab" type="button" role="tab" aria-selected="false" data-tab="t2" id="tab-rotas" aria-controls="t2">rotas.php</button>
          <button class="code-tab" type="button" role="tab" aria-selected="false" data-tab="t3" id="tab-modelo" aria-controls="t3">Modelo.php</button>
        </div>

        <div class="code-body">
          <!-- Aba 1: terminal interativo -->
          <div class="code-pane active" id="t1" role="tabpanel" aria-labelledby="tab-terminal">
            <p class="term-hint" id="termHelp">
              Escreve <code>help</code> para ver os comandos disponíveis.
              Usa as setas ↑ ↓ para o histórico e Tab para autocompletar.
            </p>
            <div class="terminal-body"
                 id="termBody"
                 role="log"
                 aria-live="polite"
                 aria-atomic="false"
                 aria-describedby="termHelp">
              <!-- output do terminal é injetado aqui -->
            </div>
          </div>

          <!-- Aba 2: rotas.php -->
          <div class="code-pane" id="t2" role="tabpanel" aria-labelledby="tab-rotas">
<span class="ln c-cm">// routes/web.php</span>
<span class="ln"><span class="c-kw">use</span> <span class="c-var">Beaver\Routing\Route</span>;</span>
<span class="ln"><span class="c-kw">use</span> <span class="c-var">App\Controllers\ProdutoController</span>;</span>
<span class="ln"> </span>
<span class="ln"><span class="c-var">Route</span>::<span class="c-fn">get</span>(<span class="c-str">'/'</span>, <span class="c-kw">fn</span>() =&gt; <span class="c-fn">view</span>(<span class="c-str">'home'</span>));</span>
<span class="ln"> </span>
<span class="ln"><span class="c-var">Route</span>::<span class="c-fn">group</span>([<span class="c-str">'prefix'</span> =&gt; <span class="c-str">'produtos'</span>, <span class="c-str">'middleware'</span> =&gt; <span class="c-str">'auth'</span>], <span class="c-kw">function</span> () {</span>
<span class="ln">    <span class="c-var">Route</span>::<span class="c-fn">get</span>(<span class="c-str">'/{id}'</span>, [<span class="c-var">ProdutoController</span>::<span class="c-kw">class</span>, <span class="c-str">'show'</span>])</span>
<span class="ln">        -&gt;<span class="c-fn">middleware</span>(<span class="c-str">'cache:60'</span>)</span>
<span class="ln">        -&gt;<span class="c-fn">name</span>(<span class="c-str">'produtos.show'</span>);</span>
<span class="ln">});</span>
          </div>

          <!-- Aba 3: Modelo.php -->
          <div class="code-pane" id="t3" role="tabpanel" aria-labelledby="tab-modelo">
<span class="ln c-cm">// app/Models/Produto.php</span>
<span class="ln"><span class="c-kw">namespace</span> <span class="c-var">App\Models</span>;</span>
<span class="ln"> </span>
<span class="ln"><span class="c-kw">use</span> <span class="c-var">Beaver\Database\Model</span>;</span>
<span class="ln"> </span>
<span class="ln"><span class="c-kw">class</span> <span class="c-fn">Produto</span> <span class="c-kw">extends</span> <span class="c-var">Model</span></span>
<span class="ln">{</span>
<span class="ln">    <span class="c-kw">protected array</span> <span class="c-var">$fillable</span> = [<span class="c-str">'nome'</span>, <span class="c-str">'preco'</span>, <span class="c-str">'stock'</span>];</span>
<span class="ln"> </span>
<span class="ln">    <span class="c-kw">public function</span> <span class="c-fn">categoria</span>(): <span class="c-var">BelongsTo</span></span>
<span class="ln">    {</span>
<span class="ln">        <span class="c-kw">return</span> <span class="c-var">$this</span>-&gt;<span class="c-fn">belongsTo</span>(<span class="c-var">Categoria</span>::<span class="c-kw">class</span>);</span>
<span class="ln">    }</span>
<span class="ln">}</span>
          </div>
        </div>
      </div>

      <div class="float-card">
        <span class="fc-ico">⚡</span>
        <span><b>342ms</b><span>tempo de arranque</span></span>
      </div>
    </div>
  </div>
</section>

<!-- ====== TRUST ====== -->
<div class="trust">
  <div class="container">
    <div class="trust-label">A framework da comunidade PHP</div>
    <div class="trust-row">
      <span>🐘 PHP 8.3+</span>
      <span>🎼 Composer</span>
      <span>⚡ PSR-7 / PSR-15</span>
      <span>🗄️ MySQL · PostgreSQL · SQLite</span>
      <span>🧪 PHPUnit</span>
      <span>🐳 Docker ready</span>
    </div>
  </div>
</div>

<!-- ====== FRAMEWORK / FEATURES ====== -->
<section class="sec" id="framework">
  <div class="container">
    <div class="sec-head center reveal">
      <div class="eyebrow">O Framework</div>
      <h2>Ferramentas afiadas para quem constrói a sério</h2>
      <p>Cada detalhe do Beaver foi desenhado para reduzir fricção: menos configuração, mais código a funcionar. Simples por fora, poderoso por dentro.</p>
    </div>

    <div class="feat-grid">
      <article class="feat reveal">
        <div class="feat-ico">⚡</div>
        <h3>Arranque em milissegundos</h3>
        <p>Um kernel leve com resolução de dependências em cache. Sem carregar meio framework para responder a um simples JSON.</p>
      </article>

      <article class="feat reveal">
        <div class="feat-ico">🧩</div>
        <h3>ORM expressivo</h3>
        <p>Relações, scopes, casts e eager loading com uma API que se lê como português. <code>Produto::ativos()-&gt;paginado(15)</code>.</p>
      </article>

      <article class="feat reveal">
        <div class="feat-ico">🛡️</div>
        <h3>Segurança por omissão</h3>
        <p>Proteção CSRF, escape automático de templates, hashing Argon2id e validação declarativa já vêm ligados de fábrica.</p>
      </article>

      <article class="feat reveal">
        <div class="feat-ico">🔌</div>
        <h3>Ecossistema aberto</h3>
        <p>Pacotes oficiais e comunitários instaláveis com um comando. Escreva o seu próprio e publique no Beaver Hub.</p>
      </article>

      <article class="feat reveal">
        <div class="feat-ico">🧪</div>
        <h3>Testes sem atrito</h3>
        <p>Base de dados em memória, factories, HTTP assertions e um runner paralelo. <code>beaver test --parallel</code>.</p>
      </article>

      <article class="feat reveal">
        <div class="feat-ico">📦</div>
        <h3>Pronto para produção</h3>
        <p>Filas, scheduler, cache em Redis, eventos, logs estruturados e um painel de diagnóstico integrado.</p>
      </article>
    </div>

    <div class="stat-strip reveal">
      <div class="stat"><b>342ms</b><span>Arranque médio em produção</span></div>
      <div class="stat"><b>98%</b><span>Cobertura de testes do core</span></div>
      <div class="stat"><b>Zero</b><span>Dependências obrigatórias externas</span></div>
    </div>
  </div>
</section>

<!-- ====== SHOWCASE ====== -->
<section class="sec" style="padding-top:20px">
  <div class="container split">
    <div class="split-copy reveal">
      <div class="eyebrow">Developer Experience</div>
      <h2 style="font-size:clamp(1.8rem,3.4vw,2.5rem);line-height:1.12;letter-spacing:-.038em;font-weight:800;margin-bottom:16px">
        Escrito por quem passa o dia a programar
      </h2>
      <p style="color:#95A3B6;font-size:1rem">
        O Beaver nasceu de anos de frustração com frameworks que prometem simplicidade e entregam
        camadas de abstração. Aqui, cada linha tem um propósito.
      </p>
      <ul class="check-list">
        <li><span class="check-ico"><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></span> CLI completa: <code style="font-family:'JetBrains Mono',monospace;font-size:.85em;color:#FFC98F">make:model</code>, <code style="font-family:'JetBrains Mono',monospace;font-size:.85em;color:#FFC98F">make:controller</code>, <code style="font-family:'JetBrains Mono',monospace;font-size:.85em;color:#FFC98F">db:seed</code></li>
        <li><span class="check-ico"><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></span> Migrações versionadas e reversíveis com um só comando</li>
        <li><span class="check-ico"><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></span> Sistema de eventos e listeners desacoplados</li>
        <li><span class="check-ico"><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></span> Container de injeção de dependências com autowiring</li>
        <li><span class="check-ico"><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></span> Documentação em português, completa e com exemplos reais</li>
      </ul>
      <div style="margin-top:32px;display:flex;gap:12px;flex-wrap:wrap">
        <button class="btn btn-primary" data-doc>Explorar documentação</button>
        <button class="btn btn-ghost" data-modal="modalRegisto">Criar conta gratuita</button>
      </div>
    </div>

    <div class="split-media reveal">
      <div class="code-window">
        <div class="code-bar">
          <div class="dots"><i></i><i></i><i></i></div>
          <div class="code-title">beaver make:controller</div>
        </div>
        <div class="code-body" style="min-height:auto">
<span class="ln"><span class="c-cmd">$</span> beaver <span class="c-fn">make:controller</span> ProdutoController <span class="c-flag">--resource</span></span>
<span class="ln"> </span>
<span class="ln c-out">  ✔ Controller criado  app/Controllers/ProdutoController.php</span>
<span class="ln c-out">  ✔ Rotas registadas  routes/web.php</span>
<span class="ln c-out">  ✔ Teste gerado     tests/Feature/ProdutoTest.php</span>
<span class="ln"> </span>
<span class="ln"><span class="c-cmd">$</span> beaver <span class="c-fn">migrate</span> <span class="c-flag">--seed</span></span>
<span class="ln c-out">  Migrando: 2024_05_12_create_produtos_table .......... <span class="c-str">DONE</span></span>
<span class="ln c-out">  Seeders executados: 4 registos inseridos</span>
<span class="ln"> </span>
<span class="ln"><span class="c-cmd">$</span> beaver <span class="c-fn">test</span> <span class="c-flag">--parallel</span></span>
<span class="ln c-out">  <span class="c-str">PASS</span>  Tests\Feature\ProdutoTest</span>
<span class="ln c-out">  Testes: 42 passaram · Duração: 1.28s</span>
<span class="ln"> </span>
<span class="ln"><span class="c-cmd">$</span> <span class="cursor"></span></span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ====== PRODUTOS ====== -->
<section class="sec" id="produtos">
  <div class="container">
    <div class="sec-head center reveal">
      <div class="eyebrow">Ecossistema</div>
      <h2>Produtos que vivem dentro do Beaver</h2>
      <p>Ferramentas oficiais desenvolvidas pela equipa do framework, integradas nativamente e prontas a usar.</p>
    </div>

    <div class="prod-grid">
      <article class="prod sql reveal">
        <div class="prod-head">
          <div class="prod-logo">🗄️</div>
          <div>
            <h3>SqlAnalyser</h3>
            <small>Database Intelligence Suite</small>
          </div>
        </div>
        <p>
          Veja exatamente o que a sua aplicação está a fazer à base de dados. O SqlAnalyser
          captura, analisa e explica cada query — com planos de execução, sugestões de índices
          e alertas de N+1 em tempo real.
        </p>
        <div class="prod-tags">
          <span class="tag-chip">Query Profiler</span>
          <span class="tag-chip">Detecção N+1</span>
          <span class="tag-chip">Sugestão de Índices</span>
          <span class="tag-chip">Explain Visual</span>
          <span class="tag-chip">MySQL · Postgres</span>
        </div>
        <div class="prod-actions">
          <button class="btn btn-primary btn-sm" data-msg="SqlAnalyser|O SqlAnalyser está disponível no plano Pro do Beaver. A redirecioná-lo para a página do produto…">Saber mais</button>
          <button class="btn btn-ghost btn-sm" data-doc>Ver docs</button>
        </div>
      </article>

      <article class="prod fra reveal">
        <div class="prod-head">
          <div class="prod-logo">🔑</div>
          <div>
            <h3>Frankey</h3>
            <small>Auth &amp; Licensing Engine</small>
          </div>
        </div>
        <p>
          Autenticação, autorização, licenciamento e gestão de chaves numa única biblioteca.
          Sessões, tokens, 2FA, permissões por papel e validação de licenças offline — tudo
          com uma API que se integra em minutos.
        </p>
        <div class="prod-tags">
          <span class="tag-chip">JWT &amp; Sessões</span>
          <span class="tag-chip">2FA / TOTP</span>
          <span class="tag-chip">RBAC</span>
          <span class="tag-chip">API Keys</span>
          <span class="tag-chip">Licenças Offline</span>
        </div>
        <div class="prod-actions">
          <button class="btn btn-primary btn-sm" data-msg="Frankey|O Frankey é open-source e instala-se com um comando. A abrir a documentação de instalação…">Saber mais</button>
          <button class="btn btn-ghost btn-sm" data-doc>Ver docs</button>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ====== LOJA ====== -->
<section class="sec" id="loja">
  <div class="container">
    <div class="sec-head reveal">
      <div class="eyebrow">Loja Oficial</div>
      <h2>Leve o Beaver consigo</h2>
      <p>Licenças, ferramentas, formação e merchandise — com fatura e download imediato.</p>
    </div>

    <div class="store-grid">
      <article class="product reveal">
        <div class="product-thumb"><span class="badge-off">-25%</span><span>🦫</span></div>
        <div class="product-body">
          <h4>Beaver Pro License</h4>
          <p>Licença comercial para 1 projeto. Suporte prioritário e acesso ao SqlAnalyser Pro.</p>
          <div class="price"><b>€129</b><s>€172</s><em>/ano</em></div>
          <button class="btn btn-primary btn-sm btn-block" data-buy="Beaver Pro License|€129">Adicionar ao carrinho</button>
        </div>
      </article>

      <article class="product reveal">
        <div class="product-thumb"><span>🗄️</span></div>
        <div class="product-body">
          <h4>SqlAnalyser Studio</h4>
          <p>Aplicação desktop para análise profunda de planos de execução e tuning de queries.</p>
          <div class="price"><b>€89</b><em>licença vitalícia</em></div>
          <button class="btn btn-primary btn-sm btn-block" data-buy="SqlAnalyser Studio|€89">Adicionar ao carrinho</button>
        </div>
      </article>

      <article class="product reveal">
        <div class="product-thumb"><span class="badge-off">NOVO</span><span>🎓</span></div>
        <div class="product-body">
          <h4>Curso: Beaver do Zero</h4>
          <p>18 horas de vídeo, 6 projetos práticos e certificado. Do primeiro comando ao deploy.</p>
          <div class="price"><b>€49</b><s>€79</s></div>
          <button class="btn btn-primary btn-sm btn-block" data-buy="Curso Beaver do Zero|€49">Adicionar ao carrinho</button>
        </div>
      </article>

      <article class="product reveal">
        <div class="product-thumb"><span>👕</span></div>
        <div class="product-body">
          <h4>Kit Dev Beaver</h4>
          <p>T-shirt oficial, stickers de teclado, autocolante para o portátil e poster A3.</p>
          <div class="price"><b>€25</b><em>+ portes</em></div>
          <button class="btn btn-primary btn-sm btn-block" data-buy="Kit Dev Beaver|€25">Adicionar ao carrinho</button>
        </div>
      </article>
    </div>

    <div style="text-align:center;margin-top:38px">
      <button class="btn btn-ghost" data-msg="Loja Beaver|A loja completa abre em breve com dezenas de produtos, métodos de pagamento locais e envios internacionais. Receberá um aviso quando estiver disponível. 🦫">
        Ver toda a loja
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </button>
    </div>
  </div>
</section>

<!-- ====== CTA / COMUNIDADE ====== -->
<section class="sec" id="comunidade" style="padding-top:20px">
  <div class="container">
    <div class="cta-band reveal">
      <div class="eyebrow" style="justify-content:center">Junte-se a nós</div>
      <h2>Pronto para roer o próximo projeto?</h2>
      <p>Crie a sua conta gratuita, instale o framework e junte-se a mais de 18.000 developers que já constroem com o Beaver.</p>
      <div class="cta-actions">
        <button class="btn btn-primary" data-modal="modalRegisto">Criar conta gratuita</button>
        <button class="btn btn-ghost" data-discord>Entrar no Discord</button>
      </div>
      <div style="margin-top:26px;font-size:.8rem;color:#66748A">
        Sem cartão de crédito · Licença MIT · Cancele quando quiser
      </div>
    </div>
  </div>
</section>

</main>

<!-- ====== FOOTER ====== -->
<footer>
  <div class="container">
    <div class="foot-grid">
      <div class="foot-brand">
        <a href="#inicio" class="brand">
          <span class="brand-logo"><svg><use href="#beaver"/></svg></span>
          <span>
            <span class="brand-name">Beaver<span class="accent">.</span></span>
            <span class="brand-sub">Framework</span>
          </span>
        </a>
        <p>Um framework PHP moderno, open-source e feito com cuidado. Roe os problemas, construa soluções.</p>
        <div class="socials">
          <a href="#" class="social" aria-label="GitHub"><svg viewBox="0 0 24 24"><path d="M12 .5C5.7.5.5 5.7.5 12c0 5.1 3.3 9.4 7.9 10.9.6.1.8-.2.8-.6v-2c-3.2.7-3.9-1.5-3.9-1.5-.5-1.3-1.3-1.7-1.3-1.7-1.1-.7.1-.7.1-.7 1.2.1 1.8 1.2 1.8 1.2 1 1.8 2.7 1.3 3.4 1 .1-.8.4-1.3.7-1.6-2.6-.3-5.3-1.3-5.3-5.8 0-1.3.5-2.3 1.2-3.1-.1-.3-.5-1.5.1-3.1 0 0 1-.3 3.3 1.2a11.5 11.5 0 016 0C17.6 4.7 18.6 5 18.6 5c.6 1.6.2 2.8.1 3.1.8.8 1.2 1.8 1.2 3.1 0 4.5-2.7 5.5-5.3 5.8.4.4.8 1.1.8 2.2v3.3c0 .3.2.7.8.6 4.6-1.5 7.9-5.8 7.9-10.9C23.5 5.7 18.3.5 12 .5z"/></svg></a>
          <a href="#" class="social" aria-label="X"><svg viewBox="0 0 24 24"><path d="M18.9 2H22l-7.1 8.1L23.2 22h-6.5l-5.1-6.7L5.8 22H2.6l7.6-8.7L1.2 2h6.7l4.6 6.1L18.9 2zm-1.1 18.1h1.7L7.3 3.8H5.5l12.3 16.3z"/></svg></a>
          <a href="#" class="social" aria-label="Discord"><svg viewBox="0 0 24 24"><path d="M20.3 4.4A19.8 19.8 0 0015.4 3l-.3.6a14.6 14.6 0 014.3 1.4 13.9 13.9 0 00-12.7 0A14.6 14.6 0 0111 3.6L10.6 3a19.8 19.8 0 00-5 1.4C2.5 8.9 1.8 13.3 2.1 17.6a19.9 19.9 0 006 3l1.3-2.1a12.9 12.9 0 01-2-1l.5-.4a14.2 14.2 0 0012.2 0l.5.4a12.9 12.9 0 01-2 1l1.3 2.1a19.9 19.9 0 006-3c.4-5-.8-9.3-3.6-13.2zM8.9 15c-1.2 0-2.1-1.1-2.1-2.4S7.7 10.2 8.9 10.2s2.2 1.1 2.1 2.4c0 1.3-.9 2.4-2.1 2.4zm6.2 0c-1.2 0-2.1-1.1-2.1-2.4s.9-2.4 2.1-2.4 2.2 1.1 2.1 2.4c0 1.3-.9 2.4-2.1 2.4z"/></svg></a>
        </div>
      </div>

      <div class="foot-col">
        <h5>Framework</h5>
        <ul>
          <li><a href="#framework">Funcionalidades</a></li>
          <li><a href="#" data-doc>Documentação</a></li>
          <li><a href="#">Guia de instalação</a></li>
          <li><a href="#">Beaver CLI</a></li>
          <li><a href="#">Changelog</a></li>
        </ul>
      </div>

      <div class="foot-col">
        <h5>Produtos</h5>
        <ul>
          <li><a href="#produtos">SqlAnalyser</a></li>
          <li><a href="#produtos">Frankey</a></li>
          <li><a href="#loja">Loja Oficial</a></li>
          <li><a href="#">Beaver Cloud</a></li>
          <li><a href="#">Pacotes</a></li>
        </ul>
      </div>

      <div class="foot-col">
        <h5>Comunidade</h5>
        <ul>
          <li><a href="#">GitHub</a></li>
          <li><a href="#">Discord</a></li>
          <li><a href="#">Blog</a></li>
          <li><a href="#">Contribuir</a></li>
          <li><a href="#">Suporte</a></li>
        </ul>
      </div>
    </div>

    <div class="foot-bottom">
      <div>© <span id="ano"></span> Beaver Framework. Todos os direitos reservados.</div>
      <div class="made">
        Feito com <span style="color:var(--amber)">🦫</span> em Portugal · Licença MIT
      </div>
    </div>
  </div>
</footer>

<!-- ====== MODAL: LOGIN ====== -->
<div class="overlay" id="modalLogin">
  <div class="modal" role="dialog" aria-modal="true">
    <button class="modal-close" data-close><svg viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
    <div class="modal-head">
      <div class="modal-ico">🦫</div>
      <h3>Bem-vindo de volta</h3>
      <p>Entre na sua conta Beaver para continuar</p>
    </div>
    <form id="formLogin" novalidate>
      <div class="field">
        <label for="loginEmail">Email</label>
        <input type="email" id="loginEmail" placeholder="teu-email@empresa.com" required>
      </div>
      <div class="field">
        <label for="loginPass">Palavra-passe</label>
        <input type="password" id="loginPass" placeholder="••••••••••" required>
      </div>
      <button type="submit" class="btn btn-primary btn-block" style="margin-top:8px">Entrar</button>
      <div class="modal-alt">
        Ainda não tem conta?
        <button type="button" data-switch="modalRegisto">Criar uma agora</button>
      </div>
      <div class="modal-note">
        <svg viewBox="0 0 24 24"><path d="M12 9v4M12 17h.01M10.3 3.9L1.8 18a2 2 0 001.7 3h17a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z"/></svg>
        <span>Este é um ambiente de demonstração. Nenhum dado é enviado ou armazenado.</span>
      </div>
    </form>
  </div>
</div>

<!-- ====== MODAL: CONVITE DISCORD ====== -->
<div class="overlay" id="modalDiscord">
  <div class="modal" role="dialog" aria-modal="true">
    <button class="modal-close" data-close><svg viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
    <div class="modal-head">
      <div class="modal-ico" style="background:linear-gradient(145deg,rgba(88,101,242,.22),rgba(88,101,242,.06));border-color:rgba(88,101,242,.35)">💬</div>
      <h3>Entrar no Discord</h3>
      <p>Deixa o teu email e enviamos-te o convite para o servidor oficial do Beaver.</p>
    </div>
    <form id="formDiscord" novalidate>
      <div class="field">
        <label for="discordEmail">Email</label>
        <input type="email" id="discordEmail" placeholder="teu-email@empresa.com" required>
      </div>
      <button type="submit" class="btn btn-primary btn-block" style="margin-top:8px">Receber convite</button>
      <div class="modal-note">
        <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        <span>Só usamos o teu email para enviar o convite do Discord. Sem spam.</span>
      </div>
    </form>
  </div>
</div>

<!-- ====== MODAL: REGISTO ====== -->
<div class="overlay" id="modalRegisto">
  <div class="modal" role="dialog" aria-modal="true">
    <button class="modal-close" data-close><svg viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
    <div class="modal-head">
      <div class="modal-ico">🚀</div>
      <h3>Criar conta gratuita</h3>
      <p>Comece a construir com o Beaver em menos de um minuto</p>
    </div>
    <form id="formRegisto" novalidate>
      <div class="field-row">
        <div class="field">
          <label for="regNome">Nome</label>
          <input type="text" id="regNome" placeholder="Ana" required>
        </div>
        <div class="field">
          <label for="regApelido">Apelido</label>
          <input type="text" id="regApelido" placeholder="Silva" required>
        </div>
      </div>
      <div class="field">
        <label for="regEmail">Email</label>
        <input type="email" id="regEmail" placeholder="voce@empresa.com" required>
      </div>
      <div class="field">
        <label for="regPass">Palavra-passe</label>
        <input type="password" id="regPass" placeholder="Mínimo 8 caracteres" required>
      </div>
      <button type="submit" class="btn btn-primary btn-block" style="margin-top:8px">Criar conta</button>
      <div class="modal-alt">
        Já tem conta?
        <button type="button" data-switch="modalLogin">Entrar</button>
      </div>
      <div class="modal-note">
        <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        <span>Ao criar conta aceita os Termos de Utilização e a Política de Privacidade do Beaver Framework.</span>
      </div>
    </form>
  </div>
</div>

<!-- ====== MODAL: MENSAGEM GENÉRICA ====== -->
<div class="overlay" id="modalMsg">
  <div class="modal" style="max-width:420px" role="dialog" aria-modal="true">
    <button class="modal-close" data-close><svg viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
    <div class="modal-head">
      <div class="modal-ico ok" id="msgIco">✅</div>
      <h3 id="msgTitulo">Tudo certo!</h3>
      <p id="msgTexto">Operação concluída com sucesso.</p>
    </div>
    <button class="btn btn-primary btn-block" data-close>Entendido</button>
  </div>
</div>

<!-- ====== CHAT BEAVER (HTML) ====== -->
<button class="chat-fab" id="chatFab" aria-label="Abrir chat">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
  </svg>
  <span class="chat-fab-badge">1</span>
</button>

<div class="chat-panel" id="chatPanel" role="dialog" aria-modal="false" aria-label="Chat com o Beaver">
<header class="chat-head">
  <span class="chat-avatar">
    <svg viewBox="0 0 64 64"><use href="#beaver"/></svg>
  </span>
  <div class="chat-head-info">
    <strong>Beaver</strong>
    <small><span class="chat-dot"></span> online · a roer</small>
  </div>

  <!-- SETA VOLTAR -->
  <button class="chat-back" id="chatBack" type="button" aria-label="Ver perguntas" hidden>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
      <path d="M19 12H5M12 19l-7-7 7-7"/>
    </svg>
  </button>

  <button class="chat-close" id="chatClose" aria-label="Fechar chat">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
  </button>
</header>

  <div class="chat-body" id="chatBody">
    <div class="chat-msg bot">
      <div class="chat-bubble">Olá! 🦫 Sou o Beaver. Estou a roer agora para finalizar esta barragem. Em que posso ajudar?</div>
    </div>
    <div class="chat-quick">
      <button data-quick="O que é o Beaver Framework?">O que é o Beaver?</button>
      <button data-quick="Como instalo o framework?">Como instalo?</button>
      <button data-quick="O que é o SqlAnalyser?">SqlAnalyser</button>
      <button data-quick="O que é o Frankey?">Frankey</button>
    </div>
  </div>

  <form class="chat-form" id="chatForm">
    <input type="text" id="chatInput" placeholder="Escreve uma mensagem…" autocomplete="off" required>
    <button type="submit" aria-label="Enviar">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
    </button>
  </form>
</div>

<script>
/* ============================================================
   BEAVER FRAMEWORK — interações
   ============================================================ */

/* ---------- Design switcher (Black / Âmbar) ---------- */
(function () {
  var root = document.documentElement;
  var toggle = document.getElementById('designToggle');
  var btn = document.getElementById('designBtn');
  if (!toggle || !btn) return;

  var KEY = 'beaver-design';
  var DEFAULT = 'amber';

  function readDesign() {
    try {
      var v = localStorage.getItem(KEY);
      return (v === 'amber' || v === 'black') ? v : DEFAULT;
    } catch (e) {
      return DEFAULT;
    }
  }

  function writeDesign(v) {
    try { localStorage.setItem(KEY, v); } catch (e) { /* noop */ }
  }

  function applyDesign(v) {
    root.setAttribute('data-design', v);
    document.querySelectorAll('.design-opt').forEach(function (o) {
      o.classList.toggle('active', o.dataset.designVal === v);
    });
  }

  var current = readDesign();
  applyDesign(current);

  btn.addEventListener('click', function (e) {
    e.stopPropagation();
    var open = toggle.classList.toggle('open');
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
  });

  document.querySelectorAll('.design-opt').forEach(function (opt) {
    opt.addEventListener('click', function () {
      var val = opt.dataset.designVal;
      applyDesign(val);
      writeDesign(val);
      toggle.classList.remove('open');
      btn.setAttribute('aria-expanded', 'false');
    });
  });

  document.addEventListener('click', function (e) {
    if (!toggle.contains(e.target)) {
      toggle.classList.remove('open');
      btn.setAttribute('aria-expanded', 'false');
    }
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      toggle.classList.remove('open');
      btn.setAttribute('aria-expanded', 'false');
    }
  });
})();

// ---------- Ano no footer ----------
var anoEl = document.getElementById('ano');
if (anoEl) anoEl.textContent = new Date().getFullYear();

// ---------- Nav: sombra ao scroll ----------
var nav = document.getElementById('nav');
if (nav) {
  var onScroll = function () { nav.classList.toggle('scrolled', window.scrollY > 12); };
  window.addEventListener('scroll', onScroll, {passive:true});
  onScroll();
}

// ---------- Menu mobile ----------
var burger   = document.getElementById('burger');
var navLinks = document.getElementById('navLinks');
if (burger && navLinks) {
  burger.addEventListener('click', function () {
    burger.classList.toggle('open');
    navLinks.classList.toggle('open');
  });
}

// ---------- Dropdown "Produtos" em mobile ----------
var dropProd   = document.getElementById('dropProd');
var dropToggle = document.getElementById('dropToggle');
if (dropProd && dropToggle) {
  dropToggle.addEventListener('click', function (e) {
    if (window.innerWidth <= 860) {
      e.preventDefault();
      dropProd.classList.toggle('open');
    }
  });
}

// ---------- Fechar menu mobile ao clicar num link ----------
if (navLinks) {
  navLinks.querySelectorAll('a').forEach(function (a) {
    a.addEventListener('click', function () {
      if (window.innerWidth <= 860 && burger && dropProd) {
        burger.classList.remove('open');
        navLinks.classList.remove('open');
        dropProd.classList.remove('open');
      }
    });
  });
}

// ---------- Abas da janela de código ----------
document.querySelectorAll('.code-tab').forEach(function (tab) {
  tab.addEventListener('click', function () {
    var wrap = tab.closest('.code-window');
    if (!wrap) return;
    wrap.querySelectorAll('.code-tab').forEach(function (t) { t.classList.remove('active'); });
    wrap.querySelectorAll('.code-pane').forEach(function (p) { p.classList.remove('active'); });
    tab.classList.add('active');
    var pane = wrap.querySelector('#' + tab.dataset.tab);
    if (pane) pane.classList.add('active');
  });
});

// ---------- Sistema de modais ----------
var lastFocused = null;

function openModal(id) {
  var el = document.getElementById(id);
  if (!el) return;
  lastFocused = document.activeElement;
  el.classList.add('open');
  document.body.style.overflow = 'hidden';
  var firstInput = el.querySelector('input');
  if (firstInput) setTimeout(function(){ firstInput.focus(); }, 260);
}

function closeModal(el) {
  if (!el) return;
  el.classList.remove('open');
  if (!document.querySelector('.overlay.open')) document.body.style.overflow = '';
  if (lastFocused) lastFocused.focus();
}

function closeAll() {
  document.querySelectorAll('.overlay.open').forEach(function (ov) { closeModal(ov); });
}

document.querySelectorAll('[data-modal]').forEach(function (btn) {
  btn.addEventListener('click', function (e) {
    e.preventDefault();
    if (window.innerWidth <= 860 && burger && navLinks) {
      burger.classList.remove('open');
      navLinks.classList.remove('open');
    }
    openModal(btn.dataset.modal);
  });
});

document.querySelectorAll('[data-close]').forEach(function (btn) {
  btn.addEventListener('click', function () { closeModal(btn.closest('.overlay')); });
});
document.querySelectorAll('.overlay').forEach(function (ov) {
  ov.addEventListener('mousedown', function (e) { if (e.target === ov) closeModal(ov); });
});
document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeAll(); });

document.querySelectorAll('[data-switch]').forEach(function (btn) {
  btn.addEventListener('click', function () {
    var atual = btn.closest('.overlay');
    closeModal(atual);
    setTimeout(function () { openModal(btn.dataset.switch); }, 160);
  });
});

// ---------- Modal de mensagem genérico ----------
var msgIco    = document.getElementById('msgIco');
var msgTitulo = document.getElementById('msgTitulo');
var msgTexto  = document.getElementById('msgTexto');

function showMessage(titulo, texto, tipo) {
  tipo = tipo || 'ok';
  if (!msgIco || !msgTitulo || !msgTexto) return;
  msgIco.className = 'modal-ico ' + tipo;
  msgIco.textContent = tipo === 'warn' ? '⚠️' : tipo === 'info' ? 'ℹ️' : '✅';
  msgTitulo.textContent = titulo;
  msgTexto.textContent  = texto;
  openModal('modalMsg');
}

document.querySelectorAll('[data-msg]').forEach(function (btn) {
  btn.addEventListener('click', function () {
    var parts = btn.dataset.msg.split('|');
    showMessage(parts[0], parts[1], 'info');
  });
});

document.querySelectorAll('[data-buy]').forEach(function (btn) {
  btn.addEventListener('click', function () {
    var parts = btn.dataset.buy.split('|');
    showMessage(
      'Adicionado ao carrinho 🛒',
      '"' + parts[0] + '" (' + parts[1] + ') foi adicionado ao seu carrinho. O checkout estará disponível em breve.',
      'ok'
    );
  });
});

document.querySelectorAll('[data-doc]').forEach(function (btn) {
  btn.addEventListener('click', function (e) {
    e.preventDefault();
    showMessage(
      'Documentação Beaver 📚',
      'A documentação oficial está em docs.beaver-framework.dev — inclui guias, referência de API e exemplos completos. O link será publicado em breve.',
      'info'
    );
  });
});

// ---------- Formulários ----------
var formLogin = document.getElementById('formLogin');
if (formLogin) {
  formLogin.addEventListener('submit', function (e) {
    e.preventDefault();
    var email = document.getElementById('loginEmail');
    var pass  = document.getElementById('loginPass');
    if (!email || !pass) return;
    if (!email.value.trim() || !/^\S+@\S+\.\S+$/.test(email.value)) {
      return showMessage('Email inválido', 'Introduza um endereço de email válido para continuar.', 'warn');
    }
    if (pass.value.length < 6) {
      return showMessage('Palavra-passe curta', 'A palavra-passe deve ter pelo menos 6 caracteres.', 'warn');
    }
    closeAll();
    setTimeout(function () {
      showMessage('Sessão iniciada 🦫', 'Bem-vindo de volta, ' + email.value.split('@')[0] + '! A sua área de cliente está pronta.', 'ok');
      e.target.reset();
    }, 200);
  });
}

var formRegisto = document.getElementById('formRegisto');
if (formRegisto) {
  formRegisto.addEventListener('submit', function (e) {
    e.preventDefault();
    var nomeEl  = document.getElementById('regNome');
    var emailEl = document.getElementById('regEmail');
    var passEl  = document.getElementById('regPass');
    if (!nomeEl || !emailEl || !passEl) return;
    var nome  = nomeEl.value.trim();
    var email = emailEl.value.trim();
    var pass  = passEl.value;
    if (!nome) return showMessage('Nome em falta', 'Precisamos do seu nome para criar a conta.', 'warn');
    if (!/^\S+@\S+\.\S+$/.test(email)) return showMessage('Email inválido', 'Introduza um endereço de email válido.', 'warn');
    if (pass.length < 8) return showMessage('Palavra-passe fraca', 'Use pelo menos 8 caracteres para manter a conta segura.', 'warn');
    closeAll();
    setTimeout(function () {
      showMessage('Conta criada com sucesso! 🎉', 'Parabéns ' + nome + '! Enviámos um email de confirmação para ' + email + '. Já pode instalar o Beaver com "composer create-project beaver/app".', 'ok');
      e.target.reset();
    }, 200);
  });
}

// ---------- Reveal on scroll ----------
if ('IntersectionObserver' in window) {
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry, i) {
      if (entry.isIntersecting) {
        setTimeout(function () { entry.target.classList.add('in'); }, i * 70);
        io.unobserve(entry.target);
      }
    });
  }, {threshold: .12, rootMargin: '0px 0px -60px 0px'});
  document.querySelectorAll('.reveal').forEach(function (el) { io.observe(el); });
} else {
  document.querySelectorAll('.reveal').forEach(function (el) { el.classList.add('in'); });
}

// ---------- Link ativo na nav ----------
var sections = Array.prototype.slice.call(document.querySelectorAll('section[id]'));
var navAnchors = Array.prototype.slice.call(document.querySelectorAll('.nav-links > a.nav-link'));
if ('IntersectionObserver' in window && sections.length) {
  var spy = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        var id = entry.target.id;
        navAnchors.forEach(function (a) {
          a.classList.toggle('active', a.getAttribute('href') === '#' + id);
        });
      }
    });
  }, {rootMargin: '-45% 0px -50% 0px'});
  sections.forEach(function (s) { spy.observe(s); });
}

// ---------- Mensagem de boas-vindas (1x por sessão) ----------
window.addEventListener('load', function () {
  if (sessionStorage.getItem('beaver_welcome')) return;
  sessionStorage.setItem('beaver_welcome', '1');
  setTimeout(function () {
    showMessage(
      'Bem-vindo ao Beaver Framework 🦫',
      'Estou a roer agora para finalizar esta barragem. Entretanto, explore a documentação, conheça o SqlAnalyser e o Frankey, ou visite a loja. Bom código!',
      'info'
    );
  }, 1400);
});

/* ============================================================
   CHAT BEAVER (JS)
   ============================================================ */
document.addEventListener('DOMContentLoaded', function () {
  var fab      = document.getElementById('chatFab');
  var panel    = document.getElementById('chatPanel');
  var closeBtn = document.getElementById('chatClose');
  var body     = document.getElementById('chatBody');
  var form     = document.getElementById('chatForm');
  var input    = document.getElementById('chatInput');

  if (!fab || !panel || !closeBtn || !body || !form || !input) {
    console.warn('[Chat Beaver] Elementos do chat em falta.');
    return;
  }

  function normalize(text) {
    return text
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '')
      .toLowerCase();
  }

  var PRICES = [
    { name: 'Beaver Pro License', price: '€129/ano' },
    { name: 'SqlAnalyser Studio', price: '€89' },
    { name: 'Curso Beaver do Zero', price: '€49' },
    { name: 'Kit Dev Beaver', price: '€25' }
  ];

  var knowledge = [
    { match: /\b(instal|composer|create-project|comec|setup|configura)/,
      reply: 'Instalas com um comando:\n\ncomposer create-project beaver/app minha-app\ncd minha-app && beaver serve\n\nEm segundos tens o servidor a correr em http://localhost:8000 ⚡' },
    { match: /\b(sqlanalyser|sqlwizard|sql|query|n\+1)\b/,
      reply: 'O SqlAnalyser é a nossa Database Intelligence Suite: captura, analisa e explica cada query — planos de execução, sugestões de índices e alertas N+1 em tempo real. Disponível no plano Pro. 🗄️' },
    { match: /\b(frankey|auth|licen|jwt|2fa|rbac)/,
      reply: 'O Frankey é o motor de autenticação e licenciamento: JWT, 2FA/TOTP, RBAC, API keys e licenças offline. Open-source, instala-se com um comando. 🔑' },
    { match: /\b(loja|compra|preco|licenc|curso|carrinho)/,
      reply: 'Na loja oficial tens a Beaver Pro License (' + PRICES[0].price + '), SqlAnalyser Studio (' + PRICES[1].price + '), o curso Beaver do Zero (' + PRICES[2].price + ') e o Kit Dev (' + PRICES[3].price + '). Tudo com fatura e download imediato. 🛒' },
    { match: /\b(documenta|docs?|guia|tutorial)/,
      reply: 'A documentação oficial está em docs.beaver-framework.dev — inclui guias, referência de API e exemplos completos. 📚' },
    { match: /\b(comunidade|discord|github|contribui)/,
      reply: 'Temos mais de 4.200 membros no Discord e 2.4k estrelas no GitHub. Junta-te à comunidade — é onde o Beaver realmente vive. 🤝' },
    { match: /\b(beaver|o que e)\b/,
      reply: 'O Beaver Framework é um framework PHP moderno, rápido e opinativo — construído pela comunidade, para a comunidade. Convenção sobre configuração, com toda a flexibilidade que precisas. 🦫' },
    { match: /\b(ola|bom dia|boa tarde|boas|hey|hi)\b/,
      reply: 'Olá! 🦫 Em que posso ajudar? Podes perguntar sobre o framework, instalação, SqlAnalyser, Frankey, loja ou documentação.' },
    { match: /\b(obrigad|thanks|valeu|brigado)/,
      reply: 'De nada! 🦫 Se precisares de mais alguma coisa, é só apitar. Bom código!' },
    { match: /\b(barragem|roer|roi)/,
      reply: 'Ah, a barragem! 🦫 Estou a roer agora para finalizar. Entretanto, aproveita para explorar o framework, conhecer o SqlAnalyser e o Frankey, ou dar uma vista de olhos na loja.' }
  ];

  function getReply(text) {
    var normalized = normalize(text);
    for (var i = 0; i < knowledge.length; i++) {
      if (knowledge[i].match.test(normalized)) return knowledge[i].reply;
    }
    return 'Boa pergunta! 🦫 Ainda estou a roer essa parte. Entretanto, experimenta perguntar sobre o framework, instalação, SqlAnalyser, Frankey, loja ou documentação.';
  }

  function scrollBottom() { body.scrollTop = body.scrollHeight; }

  function addMessage(text, who) {
    var msg = document.createElement('div');
    msg.className = 'chat-msg ' + who;
    var bubble = document.createElement('div');
    bubble.className = 'chat-bubble';
    bubble.textContent = text;
    msg.appendChild(bubble);
    body.appendChild(msg);
    scrollBottom();
  }

  function showTyping() {
    var msg = document.createElement('div');
    msg.className = 'chat-msg bot typing';
    msg.id = 'chatTyping';
    msg.innerHTML = '<div class="chat-bubble"><i></i><i></i><i></i></div>';
    body.appendChild(msg);
    scrollBottom();
  }

  function hideTyping() {
    var t = document.getElementById('chatTyping');
    if (t) t.remove();
  }

  function botReply(userText) {
    showTyping();
    var delay = 500 + Math.min(userText.length * 18, 1200);
    setTimeout(function () {
      hideTyping();
      addMessage(getReply(userText), 'bot');
    }, delay);
  }

  function openChat() {
    panel.classList.add('open');
    fab.classList.add('hidden');
    var badge = fab.querySelector('.chat-fab-badge');
    if (badge) badge.style.display = 'none';
    setTimeout(function () { input.focus(); }, 260);
  }

  function closeChat() {
    panel.classList.remove('open');
    fab.classList.remove('hidden');
  }

  fab.addEventListener('click', openChat);
  closeBtn.addEventListener('click', closeChat);

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var text = input.value.trim();
    if (!text) return;
    addMessage(text, 'user');
    input.value = '';
    botReply(text);
  });

// Guarda referência ao bloco das perguntas rápidas e ao botão voltar
var quickWrap = body.querySelector('.chat-quick');
var backBtn   = document.getElementById('chatBack');

function hideQuick() {
  if (quickWrap) quickWrap.style.display = 'none';
  if (backBtn)   backBtn.hidden = false;
}

function showQuick() {
  if (quickWrap) quickWrap.style.display = '';
  if (backBtn)   backBtn.hidden = true;
  // scroll para o topo, para o utilizador ver as perguntas
  if (body) body.scrollTop = 0;
}

// Clique numa pergunta rápida
document.querySelectorAll('.chat-quick button').forEach(function (btn) {
  btn.addEventListener('click', function () {
    var text = btn.dataset.quick;
    addMessage(text, 'user');
    botReply(text);
    hideQuick();     // esconde as perguntas em vez de as remover
  });
});

// Clique na seta ←
if (backBtn) {
  backBtn.addEventListener('click', showQuick);
}

  var pill = document.querySelector('.hero .pill');
  if (pill) {
    pill.style.cursor = 'pointer';
    pill.addEventListener('click', openChat);
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && panel.classList.contains('open') && !document.querySelector('.overlay.open')) {
      closeChat();
    }
  });
});

/* ============================================================
   TERMINAL SANDBOX
   ============================================================ */
(function () {
  var body = document.getElementById('termBody');
  var resetBtn = document.getElementById('termReset');
  if (!body) return;

  var state = {
    history: [],
    histIdx: -1,
    draft: '',
    busy: false,
    booting: false
  };

  var commands = {
    help: {
      desc: 'Lista os comandos disponíveis',
      run: function () {
        return [
          { t: 'Comandos disponíveis:', c: 'c-out' },
          { t: '', c: '' },
          { t: '  ── Framework ─────────────────────────────────────', c: 'c-out' },
          { t: '  beaver serve                           Inicia o servidor local', c: '' },
          { t: '  beaver about                           Sobre o Beaver', c: '' },
          { t: '  beaver --version                       Mostra a versão', c: '' },
          { t: '  beaver --help                          Mostra esta ajuda', c: '' },
          { t: '', c: '' },
          { t: '  ── Geração de código ─────────────────────────────', c: 'c-out' },
          { t: '  beaver make:model <Nome>               Modelo + migration + factory', c: '' },
          { t: '  beaver make:controller <Nome>          Controller (+ --resource)', c: '' },
          { t: '  beaver make:migration <nome>           Migration vazia', c: '' },
          { t: '  beaver make:seeder <Nome>              Seeder', c: '' },
          { t: '  beaver make:middleware <Nome>          Middleware', c: '' },
          { t: '  beaver make:request <Nome>             Form request', c: '' },
          { t: '', c: '' },
          { t: '  ── Base de dados ────────────────────────────────', c: 'c-out' },
          { t: '  beaver migrate                         Aplica migrações', c: '' },
          { t: '  beaver migrate --seed                  Migrações + seeders', c: '' },
          { t: '  beaver migrate:rollback                Reverte a última', c: '' },
          { t: '  beaver migrate:fresh                   Recria tudo', c: '' },
          { t: '  beaver db:seed [Nome]                  Executa seeders', c: '' },
          { t: '  beaver db:wipe                         Limpa as tabelas', c: '' },
          { t: '  beaver db:status                       Estado das migrações', c: '' },
          { t: '', c: '' },
          { t: '  ── Testes ──────────────────────────────────────', c: 'c-out' },
          { t: '  beaver test                            Todos os testes', c: '' },
          { t: '  beaver test --parallel                 Em paralelo', c: '' },
          { t: '  beaver test --filter=<Nome>            Só um teste', c: '' },
          { t: '', c: '' },
          { t: '  ── Ficheiros ───────────────────────────────────', c: 'c-out' },
          { t: '  ls                                     Lista ficheiros', c: '' },
          { t: '  pwd                                    Diretório atual', c: '' },
          { t: '  cat <ficheiro>                         Mostra conteúdo', c: '' },
          { t: '', c: '' },
          { t: '  ── Utilitários ─────────────────────────────────', c: 'c-out' },
          { t: '  clear                                  Limpa o terminal', c: '' },
          { t: '  about                                  Sobre o Beaver', c: '' }
        ];
      }
    },

    'beaver': {
      desc: 'CLI do Beaver Framework',
      run: function (args) {
        var sub = (args[0] || '').toLowerCase();

        switch (sub) {
          case 'serve':
          case 'server':
            return {
              delay: 700,
              lines: [
                { t: '  ██████╗ ███████╗ █████╗ ██╗   ██╗███████╗██████╗', c: 'c-out' },
                { t: '  ██╔══██╗██╔════╝██╔══██╗██║   ██║██╔════╝██╔══██╗', c: 'c-out' },
                { t: '  ██████╔╝█████╗  ███████║██║   ██║█████╗  ██████╔╝', c: 'c-out' },
                { t: '  ██╔══██╗██╔══╝  ██╔══██║╚██╗ ██╔╝██╔══╝  ██╔══██╗', c: 'c-out' },
                { t: '  ██████╔╝███████╗██║  ██║ ╚████╔╝ ███████╗██║  ██║', c: 'c-out' },
                { t: '  ╚═════╝ ╚══════╝╚═╝  ╚═╝  ╚═══╝  ╚══════╝╚═╝  ╚═╝', c: 'c-out' },
                { t: ' ', c: '' },
                { t: '  Beaver Framework ' + span('v' + <?= json_encode(beaver_version()) ?>, 'c-str') + '  ' + span('(PHP 8.3)', 'c-out'), c: '', raw: true },
                { t: '  ➜  Servidor local: ' + span('http://localhost:8000', 'c-str'), c: '', raw: true },
                { t: '  ➜  Pronto em ' + span('342ms', 'c-str') + ' 🦫', c: '', raw: true }
              ]
            };

          case 'about':
            return commands.about.run();

          case 'make:model':
            if (!args[1]) return err('Falta o nome do modelo. Ex: beaver make:model Produto');
            var model = capitalize(args[1]);
            var table = pluralize(model.toLowerCase());
            return {
              delay: 400,
              lines: [
                { t: '  ' + span('✔', 'c-str') + ' Modelo criado     app/Models/' + model + '.php', c: 'c-out', raw: true },
                { t: '  ' + span('✔', 'c-str') + ' Migration criada  database/migrations/2024_05_12_153045_create_' + table + '_table.php', c: 'c-out', raw: true },
                { t: '  ' + span('✔', 'c-str') + ' Factory criada    database/factories/' + model + 'Factory.php', c: 'c-out', raw: true },
                { t: '  ' + span('✔', 'c-str') + ' Seeder criado     database/seeders/' + model + 'Seeder.php', c: 'c-out', raw: true }
              ]
            };

          case 'make:controller':
            if (!args[1]) return err('Falta o nome do controller. Ex: beaver make:controller ProdutoController');
            var ctrl = args[1];
            var res = args.indexOf('--resource') !== -1;
            var cLines = [
              { t: '  ' + span('✔', 'c-str') + ' Controller criado  app/Controllers/' + ctrl + '.php', c: 'c-out', raw: true },
              { t: '  ' + span('✔', 'c-str') + ' Rotas registadas   routes/web.php', c: 'c-out', raw: true }
            ];
            if (res) cLines.push({ t: '  ' + span('✔', 'c-str') + ' Rotas resource     7 rotas geradas', c: 'c-out', raw: true });
            cLines.push({ t: '  ' + span('✔', 'c-str') + ' Teste gerado       tests/Feature/' + ctrl.replace('Controller', '') + 'Test.php', c: 'c-out', raw: true });
            return { delay: 500, lines: cLines };

          case 'make:migration':
            if (!args[1]) return err('Falta o nome da migration. Ex: beaver make:migration create_pedidos_table');
            var migName = args[1];
            var migFile = '2024_05_12_153045_' + migName + '.php';
            return {
              delay: 400,
              lines: [
                { t: '  ' + span('✔', 'c-str') + ' Migration criada  database/migrations/' + migFile, c: 'c-out', raw: true },
                { t: '  ' + span('➜', 'c-fn') + '  Edita o ficheiro para definir o schema', c: 'c-out', raw: true }
              ]
            };

          case 'make:seeder':
            if (!args[1]) return err('Falta o nome do seeder. Ex: beaver make:seeder ProdutoSeeder');
            var seedName = capitalize(args[1]);
            if (!/Seeder$/.test(seedName)) seedName += 'Seeder';
            return {
              delay: 300,
              lines: [
                { t: '  ' + span('✔', 'c-str') + ' Seeder criado  database/seeders/' + seedName + '.php', c: 'c-out', raw: true },
                { t: '  ' + span('➜', 'c-fn') + '  Corre "beaver db:seed ' + seedName.replace('Seeder', '') + '" para executar', c: 'c-out', raw: true }
              ]
            };

          case 'make:middleware':
            if (!args[1]) return err('Falta o nome do middleware. Ex: beaver make:middleware AuthMiddleware');
            var mwName = capitalize(args[1]);
            return {
              delay: 300,
              lines: [
                { t: '  ' + span('✔', 'c-str') + ' Middleware criado  app/Middleware/' + mwName + '.php', c: 'c-out', raw: true }
              ]
            };

          case 'make:request':
            if (!args[1]) return err('Falta o nome do request. Ex: beaver make:request StoreProdutoRequest');
            var reqName = capitalize(args[1]);
            return {
              delay: 300,
              lines: [
                { t: '  ' + span('✔', 'c-str') + ' Request criado  app/Requests/' + reqName + '.php', c: 'c-out', raw: true }
              ]
            };

          case 'migrate':
            var seed = args.indexOf('--seed') !== -1;
            var mLines = [
              { t: '  Migrando: 2024_05_10_create_categorias_table ......... ' + span('DONE', 'c-str'), c: 'c-out', raw: true },
              { t: '  Migrando: 2024_05_12_create_produtos_table .......... ' + span('DONE', 'c-str'), c: 'c-out', raw: true },
              { t: '  Migrando: 2024_05_14_create_utilizadores_table ...... ' + span('DONE', 'c-str'), c: 'c-out', raw: true }
            ];
            if (seed) {
              mLines.push({ t: '', c: '' });
              mLines.push({ t: '  Seeding: CategoriaSeeder .............. ' + span('8 registos', 'c-str'), c: 'c-out', raw: true });
              mLines.push({ t: '  Seeding: ProdutoSeeder ................ ' + span('42 registos', 'c-str'), c: 'c-out', raw: true });
              mLines.push({ t: '  Seeding: UtilizadorSeeder ............. ' + span('3 registos', 'c-str'), c: 'c-out', raw: true });
            }
            mLines.push({ t: '', c: '' });
            mLines.push({ t: '  ' + span('✔', 'c-str') + ' Migrações aplicadas com sucesso', c: 'c-out', raw: true });
            return { delay: 700, lines: mLines };

          case 'migrate:rollback':
          case 'migrate:reset':
            return {
              delay: 500,
              lines: [
                { t: '  Revertendo: 2024_05_14_create_utilizadores_table .... ' + span('DONE', 'c-str'), c: 'c-out', raw: true },
                { t: '', c: '' },
                { t: '  ' + span('✔', 'c-str') + ' Última migração revertida', c: 'c-out', raw: true }
              ]
            };

          case 'migrate:fresh':
            return {
              delay: 800,
              lines: [
                { t: '  ' + span('✖', 'c-str') + ' A apagar todas as tabelas...', c: 'c-out', raw: true },
                { t: '  ' + span('✔', 'c-str') + ' Tabelas apagadas', c: 'c-out', raw: true },
                { t: '', c: '' },
                { t: '  Migrando: 2024_05_10_create_categorias_table ......... ' + span('DONE', 'c-str'), c: 'c-out', raw: true },
                { t: '  Migrando: 2024_05_12_create_produtos_table .......... ' + span('DONE', 'c-str'), c: 'c-out', raw: true },
                { t: '  Migrando: 2024_05_14_create_utilizadores_table ...... ' + span('DONE', 'c-str'), c: 'c-out', raw: true },
                { t: '', c: '' },
                { t: '  ' + span('✔', 'c-str') + ' Base de dados recriada com sucesso', c: 'c-out', raw: true }
              ]
            };

          case 'test':
            var par = args.indexOf('--parallel') !== -1;
            var filter = null;
            args.forEach(function (a) {
              var m = a.match(/^--filter=(.+)$/);
              if (m) filter = m[1];
            });
            var tLines = [];
            if (filter) {
              tLines.push({ t: '  ' + span('PASS', 'c-str') + '  Tests\\Feature\\' + filter, c: 'c-out', raw: true });
              tLines.push({ t: '', c: '' });
              tLines.push({ t: '  Testes: ' + span('1 passou', 'c-str') + ' · Duração: ' + span('0.12s', 'c-str'), c: 'c-out', raw: true });
            } else {
              tLines.push({ t: '  ' + span('PASS', 'c-str') + '  Tests\\Feature\\ProdutoTest', c: 'c-out', raw: true });
              tLines.push({ t: '  ' + span('PASS', 'c-str') + '  Tests\\Feature\\AuthTest', c: 'c-out', raw: true });
              tLines.push({ t: '  ' + span('PASS', 'c-str') + '  Tests\\Feature\\CategoriaTest', c: 'c-out', raw: true });
              tLines.push({ t: '  ' + span('PASS', 'c-str') + '  Tests\\Unit\\ModelTest', c: 'c-out', raw: true });
              tLines.push({ t: '  ' + span('PASS', 'c-str') + '  Tests\\Unit\\HelperTest', c: 'c-out', raw: true });
              tLines.push({ t: '', c: '' });
              tLines.push({ t: '  Testes: ' + span('42 passaram', 'c-str') + ' · Duração: ' + span('1.28s', 'c-str') + (par ? ' · parallel' : ''), c: 'c-out', raw: true });
            }
            return { delay: 900, lines: tLines };

          case '--version':
          case '-v':
          case 'version':
            return [{ t: '  Beaver Framework ' + span('v' + <?= json_encode(beaver_version()) ?>, 'c-str') + '  ' + span('(PHP 8.3)', 'c-out'), c: '', raw: true }];

          case '--help':
          case 'help':
          case '':
            return commands.help.run();

          default:
            return err('Comando desconhecido: beaver ' + sub + '\nCorre "beaver --help" para ver os comandos.');
        }
      }
    },

    'db:seed': {
      desc: 'Executa seeders',
      run: function (args) {
        var only = args[0];
        var seeders = [
          { name: 'CategoriaSeeder',  n: 8  },
          { name: 'ProdutoSeeder',    n: 42 },
          { name: 'UtilizadorSeeder', n: 3  }
        ];
        if (only) {
          seeders = seeders.filter(function (s) {
            return s.name.toLowerCase().indexOf(only.toLowerCase()) !== -1;
          });
          if (seeders.length === 0) return err('Seeder não encontrado: ' + only);
        }
        var lines = seeders.map(function (s) {
          return { t: '  ' + span('✔', 'c-str') + ' ' + s.name + ' ................. ' + s.n + ' registos', c: 'c-out', raw: true };
        });
        var total = seeders.reduce(function (sum, s) { return sum + s.n; }, 0);
        lines.push({ t: '', c: '' });
        lines.push({ t: '  ' + span('✔', 'c-str') + ' ' + seeders.length + ' seeders · ' + total + ' registos', c: 'c-out', raw: true });
        return { delay: 600, lines: lines };
      }
    },

    'db:wipe': {
      desc: 'Limpa todas as tabelas',
      run: function () {
        return {
          delay: 500,
          lines: [
            { t: '  ' + span('✔', 'c-str') + ' Tabela produtos ....... apagada (42 registos)', c: 'c-out', raw: true },
            { t: '  ' + span('✔', 'c-str') + ' Tabela categorias ..... apagada (8 registos)', c: 'c-out', raw: true },
            { t: '  ' + span('✔', 'c-str') + ' Tabela utilizadores ... apagada (3 registos)', c: 'c-out', raw: true },
            { t: '', c: '' },
            { t: '  ' + span('✔', 'c-str') + ' Base de dados limpa', c: 'c-out', raw: true }
          ]
        };
      }
    },

    'db:status': {
      desc: 'Estado das migrações',
      run: function () {
        return [
          { t: '  Migration                                          Batch  Status', c: 'c-out' },
          { t: '  ─────────────────────────────────────────────────────────────', c: 'c-out' },
          { t: '  2024_05_10_create_categorias_table                 1      ' + span('Ran', 'c-str'), c: '', raw: true },
          { t: '  2024_05_12_create_produtos_table                   1      ' + span('Ran', 'c-str'), c: '', raw: true },
          { t: '  2024_05_14_create_utilizadores_table               1      ' + span('Ran', 'c-str'), c: '', raw: true },
          { t: '  2024_05_15_create_pedidos_table                    2      ' + span('Ran', 'c-str'), c: '', raw: true },
          { t: '', c: '' },
          { t: '  4 migrações · 0 pendentes', c: 'c-out' }
        ];
      }
    },

    cat: {
      desc: 'Mostra o conteúdo de um ficheiro',
      run: function (args) {
        if (!args[0]) return err('Uso: cat <ficheiro>\nEx: cat routes/web.php');
        var path = args.join(' ').toLowerCase();

        var files = {
          'routes/web.php': [
            { t: '// routes/web.php', c: 'c-cm', raw: true },
            { t: 'use Beaver\\Routing\\Route;', c: '' },
            { t: 'use App\\Controllers\\ProdutoController;', c: '' },
            { t: '', c: '' },
            { t: "Route::get('/', fn() => view('home'));", c: '' },
            { t: '', c: '' },
            { t: "Route::group(['prefix' => 'produtos', 'middleware' => 'auth'], function () {", c: '' },
            { t: "    Route::get('/{id}', [ProdutoController::class, 'show'])", c: '' },
            { t: "        ->middleware('cache:60')", c: '' },
            { t: "        ->name('produtos.show');", c: '' },
            { t: '});', c: '' }
          ],
          'app/models/produto.php': [
            { t: '// app/Models/Produto.php', c: 'c-cm', raw: true },
            { t: 'namespace App\\Models;', c: '' },
            { t: '', c: '' },
            { t: 'use Beaver\\Database\\Model;', c: '' },
            { t: '', c: '' },
            { t: 'class Produto extends Model', c: '' },
            { t: '{', c: '' },
            { t: "    protected array $fillable = ['nome', 'preco', 'stock'];", c: '' },
            { t: '', c: '' },
            { t: '    public function categoria(): BelongsTo', c: '' },
            { t: '    {', c: '' },
            { t: '        return $this->belongsTo(Categoria::class);', c: '' },
            { t: '    }', c: '' },
            { t: '}', c: '' }
          ],
          'composer.json': [
            { t: '{', c: '' },
            { t: '    "name": "beaver/app",', c: '' },
            { t: '    "type": "project",', c: '' },
            { t: '    "require": {', c: '' },
            { t: '        "php": "^8.3",', c: '' },
            { t: '        "beaver/framework": "^1.4"', c: '' },
            { t: '    },', c: '' },
            { t: '    "scripts": {', c: '' },
            { t: '        "serve": "beaver serve",', c: '' },
            { t: '        "test":  "beaver test"', c: '' },
            { t: '    }', c: '' },
            { t: '}', c: '' }
          ],
          '.env': [
            { t: 'APP_NAME=Beaver', c: '' },
            { t: 'APP_ENV=local', c: '' },
            { t: 'APP_DEBUG=true', c: '' },
            { t: 'APP_URL=http://localhost:8000', c: '' },
            { t: '', c: '' },
            { t: 'DB_CONNECTION=sqlite', c: '' },
            { t: 'DB_DATABASE=database/database.sqlite', c: '' },
            { t: '', c: '' },
            { t: 'CACHE_DRIVER=file', c: '' },
            { t: 'QUEUE_CONNECTION=sync', c: '' }
          ],
          'readme.md': [
            { t: '# Beaver App 🦫', c: 'c-var', raw: true },
            { t: '', c: '' },
            { t: 'Um projeto Beaver Framework.', c: '' },
            { t: '', c: '' },
            { t: '## Como correr', c: 'c-var', raw: true },
            { t: '', c: '' },
            { t: '    composer install', c: '' },
            { t: '    beaver serve', c: '' },
            { t: '', c: '' },
            { t: '## Testes', c: 'c-var', raw: true },
            { t: '', c: '' },
            { t: '    beaver test', c: '' }
          ]
        };

        var key = Object.keys(files).find(function (k) { return k === path; });
        if (!key) {
          var suffix = Object.keys(files).find(function (k) { return k.endsWith(path); });
          if (suffix) key = suffix;
        }
        if (!key) return err('Ficheiro não encontrado: ' + args.join(' ') + '\nExperimenta: cat routes/web.php');

        return files[key].map(function (l) {
          return { t: l.t, c: l.c || '', raw: l.c === 'c-cm' || l.c === 'c-var' };
        });
      }
    },

    ls: {
      desc: 'Lista ficheiros do projeto',
      run: function () {
        return [
          { t: 'app/',                       c: 'c-var' },
          { t: '  Controllers/',             c: '' },
          { t: '    ProdutoController.php',  c: '' },
          { t: '  Models/',                  c: '' },
          { t: '    Produto.php',            c: '' },
          { t: '    Categoria.php',          c: '' },
          { t: '  Middleware/',              c: '' },
          { t: '  Requests/',                c: '' },
          { t: 'database/',                  c: 'c-var' },
          { t: '  migrations/',              c: '' },
          { t: '  seeders/',                 c: '' },
          { t: '  factories/',               c: '' },
          { t: '  database.sqlite',          c: '' },
          { t: 'routes/',                    c: 'c-var' },
          { t: '  web.php',                  c: '' },
          { t: 'tests/',                     c: 'c-var' },
          { t: '  Feature/',                 c: '' },
          { t: '  Unit/',                    c: '' },
          { t: '.env',                       c: '' },
          { t: 'composer.json',              c: '' },
          { t: 'README.md',                  c: '' }
        ];
      }
    },

    pwd: {
      desc: 'Mostra o diretório atual',
      run: function () {
        return [{ t: '/home/beaver/minha-app', c: 'c-var', raw: true }];
      }
    },

    clear: {
      desc: 'Limpa o terminal',
      run: function () {
        body.innerHTML = '';
        return null;
      }
    },

    about: {
      desc: 'Sobre o Beaver Framework',
      run: function () {
        return [
          { t: 'Beaver Framework v' + <?= json_encode(beaver_version()) ?>, c: 'c-var', raw: true },
          { t: 'Roe os problemas. Construa soluções. 🦫', c: '' },
          { t: '', c: '' },
          { t: 'Um framework PHP moderno, rápido e opinativo —', c: 'c-out' },
          { t: 'construído pela comunidade, para a comunidade.', c: 'c-out' },
          { t: '', c: '' },
          { t: 'Documentação: docs.beaver-framework.dev', c: 'c-out' },
          { t: 'GitHub:       github.com/beaver-framework', c: 'c-out' }
        ];
      }
    }
  };

  commands['serve']            = commands.beaver;
  commands['make:model']       = commands.beaver;
  commands['make:controller']  = commands.beaver;
  commands['make:migration']   = commands.beaver;
  commands['make:seeder']      = commands.beaver;
  commands['make:middleware']  = commands.beaver;
  commands['make:request']     = commands.beaver;
  commands['migrate']          = commands.beaver;
  commands['migrate:rollback'] = commands.beaver;
  commands['migrate:reset']    = commands.beaver;
  commands['migrate:fresh']    = commands.beaver;
  commands['test']             = commands.beaver;

  function span(text, cls) { return '<span class="' + cls + '">' + escapeHtml(text) + '</span>'; }
  function escapeHtml(s) {
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  }
  function capitalize(s) { return s.charAt(0).toUpperCase() + s.slice(1); }
  function pluralize(s) {
    if (s.endsWith('s') || s.endsWith('x') || s.endsWith('z')) return s + 'es';
    if (s.endsWith('y')) return s.slice(0, -1) + 'ies';
    return s + 's';
  }
  function err(msg) { return [{ t: '  ✖ ' + msg, c: 'c-str' }]; }

  function appendLine(html, cls) {
    var line = document.createElement('div');
    line.className = 'term-line ' + (cls || '');
    line.innerHTML = html;
    body.appendChild(line);
    body.scrollTop = body.scrollHeight;
    return line;
  }

  function appendLines(lines, opts) {
    opts = opts || {};
    var animate = !!opts.animate;
    var speed   = opts.speed || 40;
    var onDone  = typeof opts.onDone === 'function' ? opts.onDone : null;

    if (!animate) {
      lines.forEach(function (l) {
        if (l.raw) appendLine(l.t, l.c);
        else appendLine(escapeHtml(l.t), l.c);
      });
      if (onDone) onDone();
      return;
    }

    var i = 0;

    function nextLine() {
      if (i >= lines.length) {
        if (onDone) onDone();
        return;
      }
      var l = lines[i];
      var lineEl = appendLine('', l.c || '');

      if (l.raw) {
        lineEl.style.opacity = '0';
        lineEl.innerHTML = l.t;
        lineEl.style.transition = 'opacity .15s';
        requestAnimationFrame(function () { lineEl.style.opacity = '1'; });
        i++;
        setTimeout(nextLine, speed);
      } else {
        var plain = l.t;
        var chars = String(plain).split('');
        var k = 0;
        function typeChar() {
          if (k >= chars.length) {
            i++;
            setTimeout(nextLine, speed);
            return;
          }
          lineEl.textContent += chars[k];
          body.scrollTop = body.scrollHeight;
          k++;
          setTimeout(typeChar, 12);
        }
        typeChar();
      }
    }

    nextLine();
  }

  function showPrompt(value) {
    var prompt = document.createElement('div');
    prompt.className = 'term-line term-prompt';
    prompt.innerHTML =
      '<span class="term-user">$</span>' +
      '<input class="term-input" type="text" autocomplete="off" spellcheck="false" ' +
        'value="' + escapeHtml(value || '') + '">';
    body.appendChild(prompt);
    body.scrollTop = body.scrollHeight;

    var input = prompt.querySelector('.term-input');
    input.focus();
    input.setSelectionRange(input.value.length, input.value.length);

    input.addEventListener('keydown', onInputKey);
    input.addEventListener('input', function () {
      state.draft = input.value;
      state.histIdx = -1;
    });

    return input;
  }

  function onInputKey(e) {
    var input = e.target;

    if (e.key === 'Enter') {
      e.preventDefault();
      var text = input.value.trim();
      var prompt = input.parentNode;
      prompt.innerHTML = '<span class="term-user">$</span><span>' + escapeHtml(input.value) + '</span>';

      state.booting = false;

      if (text) state.history.push(text);
      state.histIdx = -1;
      state.draft = '';

      if (!text) { showPrompt(''); return; }
      runCommand(text);
      return;
    }

    if (e.key === 'ArrowUp') {
      e.preventDefault();
      if (state.history.length === 0) return;
      if (state.histIdx === -1) state.histIdx = state.history.length;
      state.histIdx = Math.max(0, state.histIdx - 1);
      input.value = state.history[state.histIdx];
      input.setSelectionRange(input.value.length, input.value.length);
      return;
    }

    if (e.key === 'ArrowDown') {
      e.preventDefault();
      if (state.history.length === 0 || state.histIdx === -1) return;
      state.histIdx = Math.min(state.history.length, state.histIdx + 1);
      if (state.histIdx === state.history.length) {
        input.value = state.draft || '';
      } else {
        input.value = state.history[state.histIdx];
      }
      input.setSelectionRange(input.value.length, input.value.length);
      return;
    }

    if (e.key === 'Tab') {
      e.preventDefault();
      var val = input.value.trim();

      if (/^cat\s/i.test(val)) {
        var files = ['routes/web.php', 'app/Models/Produto.php', 'composer.json', '.env', 'README.md'];
        var fMatches = files.filter(function (f) {
          return f.toLowerCase().indexOf(val.slice(4).toLowerCase()) === 0;
        });
        if (fMatches.length === 1) input.value = 'cat ' + fMatches[0];
        else if (fMatches.length > 1) appendLine(escapeHtml('  ' + fMatches.join('   ')), 'c-out');
        return;
      }

      var v = val.toLowerCase();
      var top = Object.keys(commands).filter(function (k) {
        return k.indexOf(v) === 0 && k.indexOf(':') === -1;
      });
      var subs = ['make:model', 'make:controller', 'make:migration', 'make:seeder',
                  'make:middleware', 'make:request', 'migrate:rollback', 'migrate:fresh',
                  'db:seed', 'db:wipe', 'db:status'];
      var subMatches = subs.filter(function (k) { return k.indexOf(v) === 0; });

      var all = top.concat(subMatches);
      if (all.length === 1) input.value = all[0];
      else if (all.length > 1) appendLine(escapeHtml('  ' + all.join('   ')), 'c-out');
      return;
    }

    if (e.key === 'l' && (e.ctrlKey || e.metaKey)) {
      e.preventDefault();
      body.innerHTML = '';
      showPrompt('');
    }
  }

  function runCommand(text, opts) {
    opts = opts || {};
    var parts = text.split(/\s+/);
    var cmd = parts[0].toLowerCase();
    var args = parts.slice(1);

    var handler = commands[cmd];
    var result;

    if (cmd === 'beaver') {
      var sub = (args[0] || '').toLowerCase();
      if (sub === 'db:seed')   return runCommand('db:seed ' + args.slice(1).join(' '), opts);
      if (sub === 'db:wipe')   return runCommand('db:wipe', opts);
      if (sub === 'db:status') return runCommand('db:status', opts);
      if (sub === 'ls')        return runCommand('ls', opts);
      if (sub === 'pwd')       return runCommand('pwd', opts);
      if (sub === 'cat')       return runCommand('cat ' + args.slice(1).join(' '), opts);
      if (sub === 'about')     return runCommand('about', opts);
      if (sub === 'clear')     return runCommand('clear', opts);
      result = commands.beaver.run(args);

    } else if (cmd === 'serve') {
      result = commands.beaver.run(['serve']);
    } else if (cmd === 'make:model') {
      result = commands.beaver.run(['make:model'].concat(args));
    } else if (cmd === 'make:controller') {
      result = commands.beaver.run(['make:controller'].concat(args));
    } else if (cmd === 'make:migration') {
      result = commands.beaver.run(['make:migration'].concat(args));
    } else if (cmd === 'make:seeder') {
      result = commands.beaver.run(['make:seeder'].concat(args));
    } else if (cmd === 'make:middleware') {
      result = commands.beaver.run(['make:middleware'].concat(args));
    } else if (cmd === 'make:request') {
      result = commands.beaver.run(['make:request'].concat(args));
    } else if (cmd === 'migrate' || cmd === 'migrate:rollback' || cmd === 'migrate:reset' || cmd === 'migrate:fresh') {
      result = commands.beaver.run([cmd].concat(args));
    } else if (cmd === 'test') {
      result = commands.beaver.run(['test'].concat(args));
    } else if (handler) {
      result = handler.run(args);
    } else {
      result = err('Comando não encontrado: ' + cmd + '\nEscreve "help" para ver a lista.');
    }

    if (result === null) {
      showPrompt('');
      if (opts.onDone) opts.onDone();
      return;
    }

    state.busy = true;

    var lines = Array.isArray(result) ? result : result.lines;
    var delay = (result && result.delay) || 200;

    setTimeout(function () {
      appendLines(lines, {
        animate: !!opts.animate,
        speed: opts.speed || 40,
        onDone: function () {
          state.busy = false;
          showPrompt('');
          if (opts.onDone) opts.onDone();
        }
      });
    }, delay);
  }

  body.addEventListener('click', function (e) {
    if (e.target.closest('.term-input')) return;
    var input = body.querySelector('.term-input');
    if (input) input.focus();
  });

  if (resetBtn) {
    resetBtn.addEventListener('click', function () {
      state.booting = true;
      boot(true);
    });
  }

  function boot(isRestart) {
    state.booting = true;

    if (isRestart) {
      body.innerHTML = '';
    } else {
      var hint = document.getElementById('termHelp');
      if (hint) hint.remove();
    }

    if (!isRestart) {
      appendLines([
        { t: 'Beaver Framework ' + span('v' + <?= json_encode(beaver_version()) ?>, 'c-str') + ' ' + span('(PHP 8.3)', 'c-out'), c: '', raw: true },
        { t: '', c: '' }
      ]);
    }

    var prompt = document.createElement('div');
    prompt.className = 'term-line term-prompt';
    prompt.innerHTML = '<span class="term-user">$</span><span class="term-typed"></span><span class="term-caret"></span>';
    body.appendChild(prompt);
    body.scrollTop = body.scrollHeight;

    var typedEl = prompt.querySelector('.term-typed');
    var caretEl = prompt.querySelector('.term-caret');
    var cmd = 'beaver --help';
    var i = 0;
    var speed = 55;

    function typeCommand() {
      if (i < cmd.length) {
        typedEl.textContent += cmd.charAt(i);
        i++;
        body.scrollTop = body.scrollHeight;
        setTimeout(typeCommand, speed);
      } else {
        caretEl.remove();
        state.history.push(cmd);
        setTimeout(function () {
          runCommand(cmd, {
            animate: true,
            speed: 45,
            onDone: function () {
              setTimeout(function () {
                if (!state.booting || state.busy) return;
                boot(true);
              }, 3500);
            }
          });
        }, 250);
      }
    }

    setTimeout(typeCommand, 500);
  }

  boot();
})();

/* ============================================================
   DISCORD — convite (email ou mensagem)
   ============================================================ */
(function () {
  function isRegistered() {
    try {
      return sessionStorage.getItem('beaver-registered') === '1';
    } catch (e) {
      return false;
    }
  }

  function markRegistered(email) {
    try {
      sessionStorage.setItem('beaver-registered', '1');
      if (email) sessionStorage.setItem('beaver-email', email);
    } catch (e) {}
  }

  document.querySelectorAll('[data-discord]').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();

      if (isRegistered()) {
        showMessage(
          'Comunidade Beaver',
          'O servidor Discord oficial tem mais de 4.200 membros ativos. Vai receber um convite por email assim que confirmar o registo.',
          'info'
        );
      } else {
        openModal('modalDiscord');
      }
    });
  });

  var formDiscord = document.getElementById('formDiscord');
  if (formDiscord) {
    formDiscord.addEventListener('submit', function (e) {
      e.preventDefault();
      var emailEl = document.getElementById('discordEmail');
      if (!emailEl) return;
      var email = emailEl.value.trim();

      if (!/^\S+@\S+\.\S+$/.test(email)) {
        return showMessage('Email inválido', 'Introduz um endereço de email válido para receberes o convite.', 'warn');
      }

      markRegistered(email);
      closeAll();

      setTimeout(function () {
        showMessage(
          'Convite enviado 🎉',
          'Enviámos o link de convite para ' + email + '. Verifica a caixa de entrada (e o spam).',
          'ok'
        );
        e.target.reset();
      }, 200);
    });
  }
})();

/* ============================================================
   ROAR PILL — scroll para o hero
   ============================================================ */
(function () {
  var roarPill = document.getElementById('roarPill');
  if (!roarPill) return;
  roarPill.addEventListener('click', function () {
    var hero = document.getElementById('inicio');
    if (hero) hero.scrollIntoView({behavior:'smooth', block:'start'});
  });
})();
</script>
</body>
</html>