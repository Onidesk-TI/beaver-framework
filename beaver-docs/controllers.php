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
$pageTitle = 'Controllers';
$pageSubtitle = 'Lógica de pedidos, validação e respostas';
$activeSlug = 'controllers';
require __DIR__ . '/partials/head.php';
?>
<section class="beaver-section">
    <h2><i class="fas fa-diagram-project"></i>Controller básico</h2>
    <div class="beaver-card">
        <pre><code class="language-php">namespace App\Controllers;

use App\Models\Article;
use Beaver\Http\Request;
use Beaver\Http\Response;

class ArticleController
{
    public function index(): Response
    {
        $articles = Article::query()
            ->where('published', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('articles.index', compact('articles'));
    }

    public function store(Request $request): Response
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
        ]);

        Article::create($data);

        return redirect('/artigos')->with('success', 'Artigo criado!');
    }
}</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-check-double"></i>Validação</h2>
    <div class="beaver-card">
        <pre><code class="language-php">$data = $request->validate([
    'title'    => 'required|string|max:255',
    'email'    => 'required|email|unique:users,email',
    'age'      => 'nullable|integer|min:18',
    'password' => 'required|min:8|confirmed',
]);</code></pre>
        <p class="mt-2 mb-0 text-muted small">
            Falhas de validação lançam automaticamente <code class="inline-code">ValidationException</code>, capturada
            pelo handler global e devolvida como JSON (pedidos API) ou redirect com erros (pedidos web).
        </p>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-reply"></i>Tipos de resposta</h2>
    <div class="beaver-card">
        <pre><code class="language-php">return view('articles.show', compact('article'));
return redirect('/artigos');
return response()->json(['status' => 'ok']);
return response('Texto simples', 200);
abort(404, 'Artigo não encontrado');</code></pre>
    </div>
</section>

<?php require __DIR__ . '/partials/foot.php'; ?>
