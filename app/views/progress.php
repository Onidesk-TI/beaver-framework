<?php
/**
 * Beaver Framework — Progresso diário
 *
 * Vista "Agora" (o que está a ser feito) + histórico por data.
 */

declare(strict_types=1);

$daysDir = __DIR__ . '/days';

// ── Carregar dias ──
$days = [];
if (is_dir($daysDir)) {
    foreach (glob($daysDir . '/*.json') as $file) {
        $data = json_decode((string) file_get_contents($file), true);
        if (is_array($data) && !empty($data['date'])) {
            // Compatibilidade: converter 'tasks' antigo em 'done' + 'doing'
            if (isset($data['tasks']) && !isset($data['done'])) {
                $data['done']  = array_values(array_filter($data['tasks'], fn($t) => !empty($t['done'])));
                $data['doing'] = array_values(array_filter($data['tasks'], fn($t) => empty($t['done'])));
                unset($data['tasks']);
            }
            $days[] = $data;
        }
    }
    usort($days, fn($a, $b) => strcmp($b['date'], $a['date']));
}

// ── Fallback ──
if (empty($days)) {
    $days = [
        [
            'date'    => '2026-09-23',
            'title'   => 'Temas: SDK + Integração',
            'summary' => 'Construção do sistema de temas do Beaver Framework.',
            'tags'    => ['temas', 'sdk'],
            'done'    => [
                ['text' => 'Criar theme.schema.json', 'at' => '09:15'],
                ['text' => 'Criar ThemeManifest', 'at' => '09:40'],
                ['text' => 'Criar ThemeValidator', 'at' => '10:20'],
                ['text' => 'Criar ThemePaths', 'at' => '11:00'],
                ['text' => 'Criar ThemeManager', 'at' => '12:30'],
                ['text' => 'Criar config/themes.php', 'at' => '13:15'],
                ['text' => 'Registar ThemeManager no container', 'at' => '14:00'],
                ['text' => 'Adicionar rotas de assets', 'at' => '14:30'],
            ],
            'doing'   => [
                ['text' => 'Editar View::resolve() com fallback de tema', 'started' => '15:00'],
                ['text' => 'Criar helpers asset_css() / asset_js()', 'started' => '15:45'],
            ],
            'notes'   => 'Descoberta: os plugins usam <plugin>/resources/{views,ui}.',
        ],
        [
            'date'    => '2026-09-22',
            'title'   => 'Refactor: versão do framework',
            'summary' => 'Substituição de Application::VERSION por beaver_version().',
            'tags'    => ['refactor', 'versão'],
            'done'    => [
                ['text' => 'Adicionar version ao composer.json', 'at' => '10:00'],
                ['text' => 'Criar helper beaver_version()', 'at' => '10:30'],
                ['text' => 'Substituir 12 sítios', 'at' => '11:15'],
                ['text' => 'Remover a constante Application::VERSION', 'at' => '11:45'],
                ['text' => 'Remover o método Application::version()', 'at' => '12:00'],
            ],
            'doing'   => [],
            'notes'   => '',
        ],
    ];
}

// ── Estatísticas ──
$allDone  = [];
$allDoing = [];
foreach ($days as $d) {
    foreach (($d['done']  ?? []) as $t) $allDone[]  = $t;
    foreach (($d['doing'] ?? []) as $t) $allDoing[] = $t;
}
$totalTasks = count($allDone) + count($allDoing);
$doneCount  = count($allDone);
$percent    = $totalTasks > 0 ? (int) round(($doneCount / $totalTasks) * 100) : 0;

// ── Data selecionada (via ?date=YYYY-MM-DD ou 'now') ──
$selectedDate = $_GET['date'] ?? 'now';
$validDates   = array_column($days, 'date');

if ($selectedDate !== 'now' && !in_array($selectedDate, $validDates, true)) {
    $selectedDate = 'now';
}

// ── Determinar o dia a mostrar ──
if ($selectedDate === 'now') {
    // O "agora" é o dia mais recente (o primeiro da lista ordenada desc)
    $currentDay = $days[0] ?? null;
    $isNowView  = true;
} else {
    $currentDay = null;
    foreach ($days as $d) {
        if ($d['date'] === $selectedDate) { $currentDay = $d; break; }
    }
    $isNowView = false;
}

// ── Helper ──
if (!function_exists('h')) {
    function h(?string $s): string {
        return htmlspecialchars((string) $s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

// ── Formatação amigável da data ──
function fmt_date(string $iso): string {
    $ts = strtotime($iso);
    $wd = ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'][date('w', $ts)];
    $mo = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'][date('n', $ts)-1];
    return "$wd, " . date('j', $ts) . " $mo " . date('Y', $ts);
}
?>
<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Beaver · Progresso diário</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<style>
    :root {
        --bg:        #FAFAF7;
        --surface:   #FFFFFF;
        --surface-2: #F4F4EE;
        --text:      #1A1208;
        --muted:     #6B6B5F;
        --border:    rgba(26,18,8,.10);
        --border-2:  rgba(26,18,8,.06);
        --accent:    #FF6B35;
        --accent-2:  #FF9A3C;
        --success:   #16A34A;
        --pending:   #8895A7;
        --doing:     #2563EB;
    }
    [data-theme="dark"] {
        --bg:        #070A0F;
        --surface:   #131B27;
        --surface-2: #0A0F16;
        --text:      #E8EEF6;
        --muted:     #8895A7;
        --border:    rgba(255,255,255,.10);
        --border-2:  rgba(255,255,255,.06);
        --accent:    #FF9A3C;
        --accent-2:  #FF6B35;
        --success:   #4ADE80;
        --pending:   #6B7280;
        --doing:     #60A5FA;
    }

    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    html,body{height:100%}
    body{
        font-family:'Inter',system-ui,-apple-system,sans-serif;
        background:var(--bg);
        color:var(--text);
        line-height:1.6;
        -webkit-font-smoothing:antialiased;
        transition:background .25s, color .25s;
    }

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

    .date-nav{
        margin-left:auto;
        display:flex;
        align-items:center;
        gap:8px;
    }
    .date-nav label{
        font-size:.72rem;
        font-weight:600;
        color:var(--muted);
        text-transform:uppercase;
        letter-spacing:.08em;
    }
    .date-nav select{
        font-family:'JetBrains Mono',monospace;
        font-size:.8rem;
        padding:6px 12px;
        border-radius:8px;
        background:var(--surface);
        color:var(--text);
        border:1px solid var(--border);
        cursor:pointer;
        outline:none;
        transition:.15s;
        min-width:200px;
    }
    .date-nav select:hover,
    .date-nav select:focus{
        border-color:var(--accent);
        color:var(--accent);
    }

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

    .badge-now{
        display:inline-flex;
        align-items:center;
        gap:6px;
        font-size:.7rem;
        font-weight:700;
        letter-spacing:.1em;
        text-transform:uppercase;
        padding:3px 10px;
        border-radius:99px;
        background:color-mix(in srgb, var(--doing) 14%, transparent);
        color:var(--doing);
        border:1px solid color-mix(in srgb, var(--doing) 35%, transparent);
        margin-bottom:12px;
    }
    .badge-now::before{
        content:"";
        width:6px;height:6px;
        border-radius:50%;
        background:var(--doing);
        animation:pulse 1.6s ease-in-out infinite;
    }
    @keyframes pulse{
        0%,100%{opacity:1;transform:scale(1)}
        50%{opacity:.4;transform:scale(.85)}
    }

    .progress-global{
        background:var(--surface);
        border:1px solid var(--border);
        border-radius:12px;
        padding:16px 20px;
        margin-bottom:32px;
    }
    .progress-global-top{
        display:flex;
        justify-content:space-between;
        align-items:baseline;
        margin-bottom:10px;
    }
    .progress-global-label{
        font-size:.72rem;
        font-weight:700;
        letter-spacing:.14em;
        text-transform:uppercase;
        color:var(--accent);
    }
    .progress-global-value{
        font-family:'JetBrains Mono',monospace;
        font-size:.9rem;
        color:var(--text);
        font-weight:700;
    }
    .progress-bar{
        height:8px;
        background:var(--surface-2);
        border:1px solid var(--border-2);
        border-radius:99px;
        overflow:hidden;
    }
    .progress-bar-fill{
        height:100%;
        background:linear-gradient(90deg, var(--accent-2), var(--accent));
        border-radius:99px;
        transition:width .4s ease;
    }

    .day{
        background:var(--surface);
        border:1px solid var(--border);
        border-radius:14px;
        padding:20px 22px;
        margin-bottom:16px;
        transition:.2s;
    }
    .day-header{
        display:flex;
        align-items:center;
        gap:12px;
        margin-bottom:12px;
        flex-wrap:wrap;
    }
    .day-date{
        font-family:'JetBrains Mono',monospace;
        font-size:.78rem;
        color:var(--muted);
        background:var(--surface-2);
        border:1px solid var(--border-2);
        padding:3px 10px;
        border-radius:6px;
        letter-spacing:.02em;
    }
    .day-title{
        font-size:1.05rem;
        font-weight:700;
        letter-spacing:-.015em;
        color:var(--text);
    }
    .day-summary{
        color:var(--muted);
        font-size:.9rem;
        margin-bottom:14px;
    }

    .tags{
        display:flex;
        gap:6px;
        flex-wrap:wrap;
        margin-left:auto;
    }
    .tag{
        font-size:.7rem;
        font-weight:600;
        padding:3px 9px;
        border-radius:5px;
        background:color-mix(in srgb, var(--accent) 12%, transparent);
        color:var(--accent);
        border:1px solid color-mix(in srgb, var(--accent) 25%, transparent);
        letter-spacing:.02em;
        text-transform:lowercase;
    }

    /* Secções */
    .section{
        margin-top:18px;
    }
    .section-title{
        font-size:.72rem;
        font-weight:700;
        letter-spacing:.14em;
        text-transform:uppercase;
        color:var(--muted);
        margin-bottom:10px;
        display:flex;
        align-items:center;
        gap:8px;
    }
    .section-title .count{
        margin-left:auto;
        font-family:'JetBrains Mono',monospace;
        font-size:.72rem;
        color:var(--muted);
        font-weight:600;
        letter-spacing:0;
        text-transform:none;
    }
    .section.doing .section-title{color:var(--doing)}
    .section.done  .section-title{color:var(--success)}

    .tasks{
        list-style:none;
        display:flex;
        flex-direction:column;
        gap:6px;
    }
    .task{
        display:flex;
        align-items:flex-start;
        gap:10px;
        font-size:.88rem;
        line-height:1.5;
    }
    .task-icon{
        flex:none;
        width:18px;
        height:18px;
        display:grid;
        place-items:center;
        margin-top:2px;
    }
    .task-icon svg{width:14px;height:14px}
    .task.done .task-icon{color:var(--success)}
    .task.doing .task-icon{color:var(--doing)}
    .task.done .task-text{
        color:var(--muted);
        text-decoration:line-through;
        text-decoration-color:var(--border);
    }
    .task.doing .task-text{color:var(--text);font-weight:500}
    .task-time{
        margin-left:auto;
        font-family:'JetBrains Mono',monospace;
        font-size:.72rem;
        color:var(--muted);
        flex:none;
        padding-left:10px;
    }

    .empty{
        font-size:.85rem;
        color:var(--muted);
        font-style:italic;
        padding:6px 0;
    }

    .note{
        margin-top:14px;
        padding:12px 14px;
        background:var(--surface-2);
        border-left:3px solid var(--accent);
        border-radius:6px;
        font-size:.85rem;
        color:var(--muted);
        line-height:1.6;
    }

    footer{
        text-align:center;
        padding:22px 24px;
        border-top:1px solid var(--border);
        color:var(--muted);
        font-size:.8rem;
    }
    footer .accent{color:var(--accent)}
</style>
</head>
<body>

<header>
    <span class="logo">
        <svg viewBox="0 0 64 64">
            <defs>
                <linearGradient id="bvg" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0%" stop-color="#FFD79A"/>
                    <stop offset="48%" stop-color="#FF9A3C"/>
                    <stop offset="100%" stop-color="#FF6B35"/>
                </linearGradient>
            </defs>
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
        </svg>
    </span>
    <span class="brand">Beaver<span class="accent">.</span></span>
    <span class="sub">Progresso diário</span>

    <div class="date-nav">
        <label for="date-select">Dia</label>
        <select id="date-select" onchange="location.href='?date=' + this.value">
            <option value="now" <?= $isNowView ? 'selected' : '' ?>>● Agora</option>
            <?php foreach ($days as $d) : ?>
                <option value="<?= h($d['date']) ?>" <?= $selectedDate === $d['date'] ? 'selected' : '' ?>>
                    <?= h(fmt_date($d['date'])) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button class="theme-toggle" id="theme-toggle" title="Alternar tema" aria-label="Alternar tema">
        <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <circle cx="12" cy="12" r="4"/>
            <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
        </svg>
        <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
        </svg>
    </button>
</header>

<main>
    <?php if ($isNowView) : ?>
        <span class="badge-now">Agora</span>
    <?php endif; ?>

    <h1>
        <?= $isNowView
            ? 'O que está a ser feito'
            : 'Progresso do dia' ?>
    </h1>
    <p class="lead">
        <?php if ($currentDay) : ?>
            <?= h(fmt_date($currentDay['date'])) ?> ·
            <strong><?= count($currentDay['done'] ?? []) ?></strong> concluídas
            <?php if (!empty($currentDay['doing'])) : ?>
                · <strong><?= count($currentDay['doing']) ?></strong> em curso
            <?php endif; ?>
        <?php else : ?>
            Sem registos.
        <?php endif; ?>
    </p>

    <?php if ($isNowView) : ?>
        <div class="progress-global">
            <div class="progress-global-top">
                <span class="progress-global-label">Progresso global</span>
                <span class="progress-global-value"><?= $percent ?>%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-bar-fill" style="width: <?= $percent ?>%"></div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($currentDay) : ?>
        <article class="day">
            <div class="day-header">
                <span class="day-date"><?= h($currentDay['date']) ?></span>
                <h2 class="day-title"><?= h($currentDay['title']) ?></h2>
                <div class="tags">
                    <?php foreach (($currentDay['tags'] ?? []) as $tag) : ?>
                        <span class="tag">#<?= h($tag) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>

            <p class="day-summary"><?= h($currentDay['summary']) ?></p>

            <?php if (!empty($currentDay['doing'])) : ?>
                <div class="section doing">
                    <h3 class="section-title">
                        Em curso
                        <span class="count"><?= count($currentDay['doing']) ?></span>
                    </h3>
                    <ul class="tasks">
                        <?php foreach ($currentDay['doing'] as $task) : ?>
                            <li class="task doing">
                                <span class="task-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M12 7v5l3 2"/>
                                    </svg>
                                </span>
                                <span class="task-text"><?= $task['text'] ?></span>
                                <?php if (!empty($task['started'])) : ?>
                                    <span class="task-time"><?= h($task['started']) ?></span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($currentDay['done'])) : ?>
                <div class="section done">
                    <h3 class="section-title">
                        Concluídas
                        <span class="count"><?= count($currentDay['done']) ?></span>
                    </h3>
                    <ul class="tasks">
                        <?php foreach ($currentDay['done'] as $task) : ?>
                            <li class="task done">
                                <span class="task-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                </span>
                                <span class="task-text"><?= $task['text'] ?></span>
                                <?php if (!empty($task['at'])) : ?>
                                    <span class="task-time"><?= h($task['at']) ?></span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (empty($currentDay['doing']) && empty($currentDay['done'])) : ?>
                <div class="empty">Nada registado neste dia.</div>
            <?php endif; ?>

            <?php if (!empty($currentDay['notes'])) : ?>
                <div class="note"><?= $currentDay['notes'] ?></div>
            <?php endif; ?>
        </article>
    <?php else : ?>
        <div class="empty">Seleciona um dia no combo acima.</div>
    <?php endif; ?>
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

    document.getElementById('theme-toggle').addEventListener('click', function () {
        var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        root.setAttribute('data-theme', next);
        localStorage.setItem('beaver-progress-theme', next);
    });

    document.getElementById('year').textContent = new Date().getFullYear();
})();
</script>
</body>
</html>
