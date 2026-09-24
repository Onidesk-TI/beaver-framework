<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Beaver Framework — Roe os problemas. Construa soluções.</title>
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
}
body::before{
  content:"";
  position:fixed;inset:0;z-index:-2;
  background:
    radial-gradient(900px 500px at 12% -8%, rgba(255,154,60,.16), transparent 62%),
    radial-gradient(760px 460px at 88% 4%, rgba(139,123,255,.13), transparent 60%),
    radial-gradient(700px 500px at 50% 110%, rgba(255,107,53,.08), transparent 65%);
}
body::after{
  content:"";
  position:fixed;inset:0;z-index:-1;pointer-events:none;
  background-image:linear-gradient(rgba(255,255,255,.022) 1px,transparent 1px),
                   linear-gradient(90deg,rgba(255,255,255,.022) 1px,transparent 1px);
  background-size:56px 56px;
  mask-image:radial-gradient(ellipse 90% 60% at 50% 0%,#000 20%,transparent 75%);
  -webkit-mask-image:radial-gradient(ellipse 90% 60% at 50% 0%,#000 20%,transparent 75%);
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
.hero-grid{display:grid;grid-template-columns:1.05fr .95fr;gap:64px;align-items:center}

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

/* --- etiqueta "a framework da comunidade" --- */
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

/* --- Janela de código --- */
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

/* --- Card flutuante --- */
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
footer{border-top:1px solid var(--line);margin-top:100px;padding:64px 0 34px;background:rgba(5,8,12,.6)}
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
  .has-dropdown.open .dropdown{display:block}
  .burger{display:grid}
  .nav-actions .btn-ghost{display:none}
  .prod-grid{grid-template-columns:1fr}
  .cta-band{padding:48px 26px}
  .sec{padding:74px 0}
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
      <a href="#" class="nav-link" data-doc>Documentação</a>
      <a href="#comunidade" class="nav-link">Comunidade</a>
    </nav>

    <div class="nav-actions">
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
        Roe os problemas.<br>
        <span class="grad">Construa soluções.</span>
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
      <div class="code-window">
        <div class="code-bar">
          <div class="dots"><i></i><i></i><i></i></div>
          <div class="code-title">beaver — terminal</div>
        </div>
        <div class="code-tabs">
          <button class="code-tab active" data-tab="t1">terminal</button>
          <button class="code-tab" data-tab="t2">rotas.php</button>
          <button class="code-tab" data-tab="t3">Modelo.php</button>
        </div>
        <div class="code-body">
          <div class="code-pane active" id="t1">
<span class="ln c-out"># Crie o seu primeiro projeto</span>
<span class="ln"><span class="c-cmd">$</span> composer create-project beaver/app minha-app</span>
<span class="ln"><span class="c-cmd">$</span> cd minha-app <span class="c-flag">&amp;&amp;</span> beaver serve</span>
<span class="ln"> </span>
<span class="ln c-out">  ██████╗ ███████╗ █████╗ ██╗   ██╗███████╗██████╗</span>
<span class="ln c-out">  ██╔══██╗██╔════╝██╔══██╗██║   ██║██╔════╝██╔══██╗</span>
<span class="ln c-out">  ██████╔╝█████╗  ███████║██║   ██║█████╗  ██████╔╝</span>
<span class="ln c-out">  ██╔══██╗██╔══╝  ██╔══██║╚██╗ ██╔╝██╔══╝  ██╔══██╗</span>
<span class="ln c-out">  ██████╔╝███████╗██║  ██║ ╚████╔╝ ███████╗██║  ██║</span>
<span class="ln c-out">  ╚═════╝ ╚══════╝╚═╝  ╚═╝  ╚═══╝  ╚══════╝╚═╝  ╚═╝</span>
<span class="ln"> </span>
<span class="ln">  <span class="c-var">Beaver Framework</span> <span class="c-str">v1.4.0</span>  <span class="c-out">(PHP 8.3)</span></span>
<span class="ln">  <span class="c-fn">➜</span>  Servidor local: <span class="c-str">http://localhost:8000</span></span>
<span class="ln">  <span class="c-fn">➜</span>  Pronto em <span class="c-str">342ms</span> 🦫<span class="cursor"></span></span>
          </div>

          <div class="code-pane" id="t2">
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

          <div class="code-pane" id="t3">
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
        <button class="btn btn-ghost" data-msg="Comunidade Beaver|O servidor Discord oficial tem mais de 4.200 membros ativos. Vai receber um convite por email assim que confirmar o registo.">Entrar no Discord</button>
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
        <input type="email" id="loginEmail" placeholder="voce@empresa.com" required>
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

<script>
/* ============================================================
   BEAVER FRAMEWORK — interações
   ============================================================ */

// ---------- Ano no footer ----------
document.getElementById('ano').textContent = new Date().getFullYear();

// ---------- Nav: sombra ao scroll ----------
const nav = document.getElementById('nav');
const onScroll = () => nav.classList.toggle('scrolled', window.scrollY > 12);
window.addEventListener('scroll', onScroll, {passive:true});
onScroll();

// ---------- Menu mobile ----------
const burger   = document.getElementById('burger');
const navLinks = document.getElementById('navLinks');
burger.addEventListener('click', () => {
  burger.classList.toggle('open');
  navLinks.classList.toggle('open');
});

// ---------- Dropdown "Produtos" em mobile ----------
const dropProd   = document.getElementById('dropProd');
const dropToggle = document.getElementById('dropToggle');
dropToggle.addEventListener('click', (e) => {
  if (window.innerWidth <= 860) {
    e.preventDefault();
    dropProd.classList.toggle('open');
  }
});

// ---------- Fechar menu mobile ao clicar num link ----------
navLinks.querySelectorAll('a').forEach(a => {
  a.addEventListener('click', () => {
    if (window.innerWidth <= 860) {
      burger.classList.remove('open');
      navLinks.classList.remove('open');
      dropProd.classList.remove('open');
    }
  });
});

// ---------- Abas da janela de código ----------
document.querySelectorAll('.code-tab').forEach(tab => {
  tab.addEventListener('click', () => {
    const wrap = tab.closest('.code-window');
    wrap.querySelectorAll('.code-tab').forEach(t => t.classList.remove('active'));
    wrap.querySelectorAll('.code-pane').forEach(p => p.classList.remove('active'));
    tab.classList.add('active');
    wrap.querySelector('#' + tab.dataset.tab).classList.add('active');
  });
});

// ---------- Sistema de modais ----------
let lastFocused = null;

function openModal(id) {
  const el = document.getElementById(id);
  if (!el) return;
  lastFocused = document.activeElement;
  el.classList.add('open');
  document.body.style.overflow = 'hidden';
  const firstInput = el.querySelector('input');
  if (firstInput) setTimeout(() => firstInput.focus(), 260);
}

function closeModal(el) {
  el.classList.remove('open');
  if (!document.querySelector('.overlay.open')) {
    document.body.style.overflow = '';
  }
  if (lastFocused) lastFocused.focus();
}

function closeAll() {
  document.querySelectorAll('.overlay.open').forEach(closeModal);
}

// Abrir por data-modal
document.querySelectorAll('[data-modal]').forEach(btn => {
  btn.addEventListener('click', (e) => {
    e.preventDefault();
    if (window.innerWidth <= 860) {
      burger.classList.remove('open');
      navLinks.classList.remove('open');
    }
    openModal(btn.dataset.modal);
  });
});

// Fechar
document.querySelectorAll('[data-close]').forEach(btn => {
  btn.addEventListener('click', () => closeModal(btn.closest('.overlay')));
});
document.querySelectorAll('.overlay').forEach(ov => {
  ov.addEventListener('mousedown', (e) => { if (e.target === ov) closeModal(ov); });
});
document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeAll(); });

// Trocar entre login e registo
document.querySelectorAll('[data-switch]').forEach(btn => {
  btn.addEventListener('click', () => {
    const atual = btn.closest('.overlay');
    closeModal(atual);
    setTimeout(() => openModal(btn.dataset.switch), 160);
  });
});

// ---------- Modal de mensagem genérico ----------
const msgIco    = document.getElementById('msgIco');
const msgTitulo = document.getElementById('msgTitulo');
const msgTexto  = document.getElementById('msgTexto');

function showMessage(titulo, texto, tipo = 'ok') {
  msgIco.className = 'modal-ico ' + tipo;
  msgIco.textContent = tipo === 'warn' ? '⚠️' : tipo === 'info' ? 'ℹ️' : '✅';
  msgTitulo.textContent = titulo;
  msgTexto.textContent  = texto;
  openModal('modalMsg');
}

// Botões data-msg="Título|Mensagem"
document.querySelectorAll('[data-msg]').forEach(btn => {
  btn.addEventListener('click', () => {
    const [t, m] = btn.dataset.msg.split('|');
    showMessage(t, m, 'info');
  });
});

// Compras da loja
document.querySelectorAll('[data-buy]').forEach(btn => {
  btn.addEventListener('click', () => {
    const [nome, preco] = btn.dataset.buy.split('|');
    showMessage(
      'Adicionado ao carrinho 🛒',
      `"${nome}" (${preco}) foi adicionado ao seu carrinho. O checkout estará disponível em breve.`,
      'ok'
    );
  });
});

// Documentação (placeholder)
document.querySelectorAll('[data-doc]').forEach(btn => {
  btn.addEventListener('click', (e) => {
    e.preventDefault();
    showMessage(
      'Documentação Beaver 📚',
      'A documentação oficial está em docs.beaver-framework.dev — inclui guias, referência de API e exemplos completos. O link será publicado em breve.',
      'info'
    );
  });
});

// ---------- Formulário de login ----------
document.getElementById('formLogin').addEventListener('submit', (e) => {
  e.preventDefault();
  const email = document.getElementById('loginEmail');
  const pass  = document.getElementById('loginPass');

  if (!email.value.trim() || !/^\S+@\S+\.\S+$/.test(email.value)) {
    return showMessage('Email inválido', 'Introduza um endereço de email válido para continuar.', 'warn');
  }
  if (pass.value.length < 6) {
    return showMessage('Palavra-passe curta', 'A palavra-passe deve ter pelo menos 6 caracteres.', 'warn');
  }

  closeAll();
  setTimeout(() => {
    showMessage('Sessão iniciada 🦫', `Bem-vindo de volta, ${email.value.split('@')[0]}! A sua área de cliente está pronta.`, 'ok');
    e.target.reset();
  }, 200);
});

// ---------- Formulário de registo ----------
document.getElementById('formRegisto').addEventListener('submit', (e) => {
  e.preventDefault();
  const nome  = document.getElementById('regNome').value.trim();
  const email = document.getElementById('regEmail').value.trim();
  const pass  = document.getElementById('regPass').value;

  if (!nome) return showMessage('Nome em falta', 'Precisamos do seu nome para criar a conta.', 'warn');
  if (!/^\S+@\S+\.\S+$/.test(email)) return showMessage('Email inválido', 'Introduza um endereço de email válido.', 'warn');
  if (pass.length < 8) return showMessage('Palavra-passe fraca', 'Use pelo menos 8 caracteres para manter a conta segura.', 'warn');

  closeAll();
  setTimeout(() => {
    showMessage('Conta criada com sucesso! 🎉', `Parabéns ${nome}! Enviámos um email de confirmação para ${email}. Já pode instalar o Beaver com "composer create-project beaver/app".`, 'ok');
    e.target.reset();
  }, 200);
});

// ---------- Reveal on scroll ----------
const io = new IntersectionObserver((entries) => {
  entries.forEach((entry, i) => {
    if (entry.isIntersecting) {
      setTimeout(() => entry.target.classList.add('in'), i * 70);
      io.unobserve(entry.target);
    }
  });
}, {threshold: .12, rootMargin: '0px 0px -60px 0px'});

document.querySelectorAll('.reveal').forEach(el => io.observe(el));

// ---------- Link ativo na nav conforme a secção ----------
const sections = [...document.querySelectorAll('section[id]')];
const navAnchors = [...document.querySelectorAll('.nav-links > a.nav-link')];

const spy = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const id = entry.target.id;
      navAnchors.forEach(a => {
        a.classList.toggle('active', a.getAttribute('href') === '#' + id);
      });
    }
  });
}, {rootMargin: '-45% 0px -50% 0px'});

sections.forEach(s => spy.observe(s));

// ---------- Mensagem de boas-vindas (1x por sessão) ----------
window.addEventListener('load', () => {
  if (sessionStorage.getItem('beaver_welcome')) return;
  sessionStorage.setItem('beaver_welcome', '1');
  setTimeout(() => {
    showMessage(
      'Bem-vindo ao Beaver Framework 🦫',
      'Estou a roer agora para finalizar esta barragem. Entretanto, explore a documentação, conheça o SqlAnalyser e o Frankey, ou visite a loja. Bom código!',
      'info'
    );
  }, 1400);
});
</script>
</body>
</html>