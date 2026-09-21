<?php
// partials/foot.php
// Espera $activeSlug definido. $navItems já vem de head.php (mesmo request).

$currentIndex = null;
foreach ($navItems as $i => $item) {
    if ($item['slug'] === $activeSlug) {
        $currentIndex = $i;
        break;
    }
}
$prev = $currentIndex !== null && $currentIndex > 0 ? $navItems[$currentIndex - 1] : null;
$next = $currentIndex !== null && $currentIndex < count($navItems) - 1 ? $navItems[$currentIndex + 1] : null;
?>
            <div class="beaver-pager">
                <div>
                    <?php if ($prev): ?>
                        <a href="<?= $prev['file'] ?>"><i class="fas fa-arrow-left me-1"></i> <?= htmlspecialchars($prev['label']) ?></a>
                    <?php endif; ?>
                </div>
                <div>
                    <?php if ($next): ?>
                        <a href="<?= $next['file'] ?>"><?= htmlspecialchars($next['label']) ?> <i class="fas fa-arrow-right ms-1"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>
</body>
</html>
