<?php

/**
 * Beaver Framework — Modern PHP framework with a plugin ecosystem.
 *
 * @package    Beaver Framework
 * @version    0.1.0
 * @author     Franco <onidesk@outlook.com>
 * @copyright  2026 Onidesk
 * @license    GPL-3.0-or-later <https://www.gnu.org/licenses/gpl-3.0.txt>
 * @link       https://github.com/Onidesk-TI/beaver-framework
 */

$navContext = $navContext ?? 'default';
$navExtra   = $navExtra   ?? [];
?>
<header>
  <div class="nav-inner">
    <a href="/" class="brand">
      <span class="brand-logo"><svg><use href="#beaver"/></svg></span>
      <span>
        <span class="brand-name">Beaver<span class="accent">.</span></span>
        <span class="brand-sub">Framework <?= htmlspecialchars((string)($version ?? '')) ?></span>
      </span>
    </a>

    <?php require __DIR__ . '/nav.php'; ?>
  </div>
</header>