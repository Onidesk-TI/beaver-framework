<?php

declare(strict_types=1);

namespace Beaver\Plugins\Paginator;

class Pager
{
    public int $current;
    public int $total;
    public string $url;
    public int $window;

    public bool $showEnds     = true;
    public bool $showPrevNext = true;

    public string $labelPrev  = '‹ Anterior';
    public string $labelNext  = 'Próxima ›';
    public string $labelFirst = '« Primeira';
    public string $labelLast  = 'Última »';

    public ?int $totalItems = null;
    public int  $perPage    = 10;

    public function __construct(
        int $current = 1,
        int $total = 1,
        string $url = '?page=',
        int $window = 2
    ) {
        $this->current = max(1, $current);
        $this->total   = max(1, $total);
        $this->url     = $url;
        $this->window  = max(1, $window);
    }

    public static function make(array $opts = []): self
    {
        $p = new self(
            (int)    ($opts['current'] ?? 1),
            (int)    ($opts['total']   ?? 1),
            (string) ($opts['url']     ?? '?page='),
            (int)    ($opts['window']  ?? 2)
        );

        if (isset($opts['showEnds']))     $p->showEnds     = (bool) $opts['showEnds'];
        if (isset($opts['showPrevNext'])) $p->showPrevNext = (bool) $opts['showPrevNext'];
        if (isset($opts['labelPrev']))    $p->labelPrev    = (string) $opts['labelPrev'];
        if (isset($opts['labelNext']))    $p->labelNext    = (string) $opts['labelNext'];
        if (isset($opts['labelFirst']))   $p->labelFirst   = (string) $opts['labelFirst'];
        if (isset($opts['labelLast']))    $p->labelLast    = (string) $opts['labelLast'];
        if (isset($opts['totalItems']))   $p->totalItems   = (int) $opts['totalItems'];
        if (isset($opts['perPage']))      $p->perPage      = max(1, (int) $opts['perPage']);

        return $p;
    }

    public function render(): string
    {
        if ($this->total <= 1) return '';

        $h   = [];
        $url = htmlspecialchars($this->url, ENT_QUOTES);
        $cur = $this->current;
        $tot = $this->total;
        $win = $this->window;

        $h[] = '<nav class="paginator" aria-label="Paginação">';

        if ($this->totalItems !== null) {
            $from = ($cur - 1) * $this->perPage + 1;
            $to   = min($cur * $this->perPage, $this->totalItems);
            $h[]  = '<span class="pg-info">' . $from . '–' . $to . ' de ' . $this->totalItems . '</span>';
        }

        if ($this->showEnds && $this->showPrevNext && $cur > $win + 1) {
            $h[] = $this->link($url . 1, $this->labelFirst);
        }

        if ($this->showPrevNext) {
            $h[] = ($cur > 1)
                ? $this->link($url . ($cur - 1), $this->labelPrev, 'rel="prev"')
                : '<span class="pg-btn is-disabled">' . htmlspecialchars($this->labelPrev) . '</span>';
        }

        $start = max(1, $cur - $win);
        $end   = min($tot, $cur + $win);

        if ($start > 1) {
            $h[] = $this->link($url . 1, '1');
            if ($start > 2) $h[] = '<span class="pg-gap">…</span>';
        }

        for ($i = $start; $i <= $end; $i++) {
            $h[] = ($i === $cur)
                ? '<span class="pg-btn is-active" aria-current="page">' . $i . '</span>'
                : $this->link($url . $i, (string) $i);
        }

        if ($end < $tot) {
            if ($end < $tot - 1) $h[] = '<span class="pg-gap">…</span>';
            $h[] = $this->link($url . $tot, (string) $tot);
        }

        if ($this->showPrevNext) {
            $h[] = ($cur < $tot)
                ? $this->link($url . ($cur + 1), $this->labelNext, 'rel="next"')
                : '<span class="pg-btn is-disabled">' . htmlspecialchars($this->labelNext) . '</span>';
        }

        if ($this->showEnds && $this->showPrevNext && $cur < $tot - $win) {
            $h[] = $this->link($url . $tot, $this->labelLast);
        }

        $h[] = '</nav>';

        return implode('', $h);
    }

    public function __toString(): string
    {
        return $this->render();
    }

    private function link(string $href, string $label, string $extra = ''): string
    {
        $href  = htmlspecialchars($href, ENT_QUOTES);
        $label = htmlspecialchars($label);
        $extra = $extra ? ' ' . $extra : '';
        return '<a class="pg-btn" href="' . $href . '"' . $extra . '>' . $label . '</a>';
    }
}
