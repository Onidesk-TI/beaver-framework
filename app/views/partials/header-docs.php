<?php

/**
 * Header alternativo para a secção de documentação.
 * Usa sprites SVG (#beaver, #ico-home, #ico-book, #ico-gh)
 * e as classes .nav-inner / .nav-links / .nav-link / .nav-cta.
 */

$active   = $active ?? 'documentation';   // 'home' | 'documentation'
$version  = $version ?? '';
$repoUrl  = $repoUrl ?? 'https://github.com/Onidesk-TI/beaver-framework';
?>
<header>
  <div class="nav-inner">
    <a href="/" class="brand" aria-label="Beaver Framework — início">
      <span class="brand-logo"><svg aria-hidden="true"><use href="#beaver"/></svg></span>
      <span class="brand-text">
        <span class="brand-name">Beaver<span class="accent">.</span></span>
        <span class="brand-sub">Framework</span>
      </span>
    </a>

    <nav class="nav-links" aria-label="Navegação principal">
      <a class="nav-link<?= $active === 'home' ? ' active' : '' ?>"
         href="/"
         <?= $active === 'home' ? 'aria-current="page"' : '' ?>>
        <svg aria-hidden="true"><use href="#ico-home"/></svg>
        <span>Home</span>
      </a>

      <a class="nav-link<?= $active === 'documentation' ? ' active' : '' ?>"
         href="/documentation"
         <?= $active === 'documentation' ? 'aria-current="page"' : '' ?>>
        <svg aria-hidden="true"><use href="#ico-book"/></svg>
        <span>Documentação</span>
      </a>

      <a class="nav-cta" href="<?= htmlspecialchars($repoUrl, ENT_QUOTES) ?>"
         target="_blank" rel="noopener noreferrer">
        <svg aria-hidden="true"><use href="#ico-gh"/></svg>
        GitHub
      </a>
    </nav>
  </div>
</header>
<?php
unset($active, $version, $repoUrl);
?>