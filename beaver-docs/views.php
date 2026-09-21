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
$pageTitle = 'Views (Templates)';
$pageSubtitle = 'Sintaxe de templates compatível com Blade';
$activeSlug = 'views';
require __DIR__ . '/partials/head.php';
?>
<section class="beaver-section">
    <h2><i class="fas fa-window-restore"></i>Layout base</h2>
    <div class="beaver-card">
        <p><code class="inline-code">resources/views/layouts/app.blade.php</code>:</p>
        <pre><code class="language-blade">&lt;!DOCTYPE html&gt;
&lt;html lang="pt"&gt;
&lt;head&gt;
    &lt;title&gt;@yield('title', 'Meu Site')&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    @include('partials.header')

    &lt;main&gt;
        @yield('content')
    &lt;/main&gt;

    @include('partials.footer')
&lt;/body&gt;
&lt;/html&gt;</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-code"></i>Estender e escrever conteúdo</h2>
    <div class="beaver-card">
        <pre><code class="language-blade">@extends('layouts.app')

@section('title', $article->title)

@section('content')
    &lt;h1&gt;{{ $article->title }}&lt;/h1&gt;
    &lt;p&gt;{{ $article->body }}&lt;/p&gt;

    @foreach ($article->comments as $comment)
        &lt;div class="comment"&gt;{{ $comment->text }}&lt;/div&gt;
    @endforeach

    @if ($article->comments->isEmpty())
        &lt;p&gt;Sem comentários ainda.&lt;/p&gt;
    @endif
@endsection</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-shield-halved"></i>Proteção contra XSS</h2>
    <div class="beaver-card">
        <p class="mb-2"><code class="inline-code">{{ }}</code> escapa automaticamente HTML — só usa <code class="inline-code">{!! !!}</code> quando tens a certeza de que o conteúdo é seguro:</p>
        <pre><code class="language-blade">{{ $comentarioDoUtilizador }}   {{-- seguro: HTML escapado --}}
{!! $htmlDeConfianca !!}        {{-- perigoso se vier de input do utilizador --}}</code></pre>
        <p class="mt-2 mb-0 text-muted small">
            O scanner do FrankenPHP sinaliza qualquer uso de <code class="inline-code">{!! !!}</code> com dados vindos
            diretamente de <code class="inline-code">$request</code> sem sanitização prévia.
        </p>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-puzzle-piece"></i>Componentes</h2>
    <div class="beaver-card">
        <pre><code class="language-blade">{{-- resources/views/components/alert.blade.php --}}
&lt;div class="alert alert-{{ $type ?? 'info' }}"&gt;
    {{ $slot }}
&lt;/div&gt;</code></pre>
        <pre><code class="language-blade">&lt;x-alert type="success"&gt;
    Artigo guardado com sucesso!
&lt;/x-alert&gt;</code></pre>
    </div>
</section>

<?php require __DIR__ . '/partials/foot.php'; ?>
