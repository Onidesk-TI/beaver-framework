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
$pageTitle = 'Exemplo Completo';
$pageSubtitle = 'Um CRUD mínimo, do routing à view';
$activeSlug = 'exemplo';
require __DIR__ . '/partials/head.php';
?>
<section class="beaver-section">
    <h2><i class="fas fa-flag-checkered"></i>Rotas</h2>
    <div class="beaver-card">
        <pre><code class="language-php">// routes/web.php
Route::get('/tarefas', [TaskController::class, 'index']);
Route::post('/tarefas', [TaskController::class, 'store']);
Route::delete('/tarefas/{id}', [TaskController::class, 'destroy']);</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-diagram-project"></i>Controller</h2>
    <div class="beaver-card">
        <pre><code class="language-php">// app/Controllers/TaskController.php
class TaskController
{
    public function index(): Response
    {
        $tasks = Task::query()->orderBy('created_at', 'desc')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request): Response
    {
        Task::create($request->validate(['title' => 'required|string|max:255']));
        return redirect('/tarefas');
    }

    public function destroy(int $id): Response
    {
        Task::findOrFail($id)->delete();
        return redirect('/tarefas');
    }
}</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-cube"></i>Model + Migration</h2>
    <div class="beaver-card">
        <pre><code class="language-php">// app/Models/Task.php
class Task extends Model
{
    protected array $fillable = ['title', 'done'];
}</code></pre>
        <pre><code class="language-php">// database/migrations/xxxx_create_tasks_table.php
Schema::create('tasks', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->boolean('done')->default(false);
    $table->timestamps();
});</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-window-restore"></i>View</h2>
    <div class="beaver-card">
        <pre><code class="language-blade">{{-- resources/views/tasks/index.blade.php --}}
@extends('layouts.app')

@section('content')
    &lt;form method="POST" action="/tarefas"&gt;
        @csrf
        &lt;input type="text" name="title" placeholder="Nova tarefa"&gt;
        &lt;button type="submit"&gt;Adicionar&lt;/button&gt;
    &lt;/form&gt;

    &lt;ul&gt;
        @foreach ($tasks as $task)
            &lt;li&gt;
                {{ $task->title }}
                &lt;form method="POST" action="/tarefas/{{ $task->id }}" style="display:inline"&gt;
                    @csrf
                    @method('DELETE')
                    &lt;button type="submit"&gt;Remover&lt;/button&gt;
                &lt;/form&gt;
            &lt;/li&gt;
        @endforeach
    &lt;/ul&gt;
@endsection</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-vial"></i>Testar</h2>
    <div class="beaver-card">
        <pre><code class="language-bash">php beaver migrate
php beaver serve
php beaver security:scan   # confirmar que o CRUD não introduziu problemas</code></pre>
    </div>
</section>

<?php require __DIR__ . '/partials/foot.php'; ?>
