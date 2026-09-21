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
$pageTitle = 'Jobs (Filas)';
$pageSubtitle = 'Processamento assíncrono de tarefas em background';
$activeSlug = 'jobs';
require __DIR__ . '/partials/head.php';
?>
<section class="beaver-section">
    <h2><i class="fas fa-layer-group"></i>O que são Jobs</h2>
    <div class="beaver-card">
        <p class="mb-0">
            Um <strong>Job</strong> é uma unidade de trabalho que, em vez de correr durante o pedido HTTP (deixando
            o utilizador à espera), é colocada numa fila e processada em background por um <strong>worker</strong>.
            Útil para envio de emails, processamento de imagens, chamadas a APIs externas lentas, geração de relatórios, etc.
        </p>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-cog"></i>Configuração</h2>
    <div class="beaver-card">
        <p class="mb-2"><code class="inline-code">config/queue.php</code>:</p>
        <pre><code class="language-php">return [
    'default' => env('QUEUE_DRIVER', 'database'),

    'connections' => [
        'sync'     => ['driver' => 'sync'],       // executa imediatamente, útil em testes
        'database' => ['driver' => 'database', 'table' => 'jobs', 'queue' => 'default'],
        'redis'    => ['driver' => 'redis', 'connection' => 'default', 'queue' => 'default'],
    ],
];</code></pre>
        <pre><code class="language-bash">php beaver make:migration create_jobs_table   # se usares o driver 'database'
php beaver migrate</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-plus"></i>Criar um Job</h2>
    <div class="beaver-card">
        <pre><code class="language-bash">php beaver make:job SendWelcomeEmailJob</code></pre>
        <pre><code class="language-php">namespace App\Jobs;

use Beaver\Queue\Job;
use App\Models\User;
use App\Mail\WelcomeMail;

class SendWelcomeEmailJob extends Job
{
    public int $tries = 3;          // tentativas antes de marcar como falhado
    public int $timeout = 30;       // segundos
    public int $backoff = 60;       // espera entre tentativas

    public function __construct(
        private readonly int $userId
    ) {}

    public function handle(): void
    {
        $user = User::findOrFail($this->userId);
        Mail::to($user->email)->send(new WelcomeMail($user));
    }

    public function failed(\Throwable $exception): void
    {
        // corre depois de esgotar todas as tentativas
        Log::error("Falha ao enviar email de boas-vindas ao user {$this->userId}: {$exception->getMessage()}");
    }
}</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-paper-plane"></i>Despachar (dispatch)</h2>
    <div class="beaver-card">
        <pre><code class="language-php">// No controller, depois de criar o utilizador
use App\Jobs\SendWelcomeEmailJob;

class RegisterController
{
    public function store(Request $request): Response
    {
        $user = User::create($request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]));

        // Vai para a fila — não bloqueia a resposta ao utilizador
        SendWelcomeEmailJob::dispatch($user->id);

        // Variantes úteis:
        SendWelcomeEmailJob::dispatch($user->id)->onQueue('emails');
        SendWelcomeEmailJob::dispatch($user->id)->delay(300);      // daqui a 5 minutos
        SendWelcomeEmailJob::dispatchSync($user->id);              // executa já, sem fila (debug)

        return redirect('/bem-vindo');
    }
}</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-server"></i>Correr o worker</h2>
    <div class="beaver-card">
        <pre><code class="language-bash"># Processa jobs continuamente
php beaver queue:work

# Numa fila específica, com limite de tentativas e timeout customizados
php beaver queue:work --queue=emails --tries=3 --timeout=30

# Processa só os jobs pendentes agora e termina (não fica em loop)
php beaver queue:work --once</code></pre>
        <p class="mt-2 mb-0 text-muted small">
            Em produção corre normalmente sob um supervisor de processos (systemd, Supervisor) para reiniciar
            o worker automaticamente se cair.
        </p>
        <pre class="mt-2"><code class="language-ini"># /etc/systemd/system/beaver-worker.service
[Unit]
Description=Beaver Queue Worker
After=network.target

[Service]
User=www-data
WorkingDirectory=/var/www/onidesk/meu-projeto
ExecStart=/usr/bin/php beaver queue:work --sleep=3 --tries=3
Restart=always

[Install]
WantedBy=multi-user.target</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-triangle-exclamation"></i>Jobs falhados</h2>
    <div class="beaver-card">
        <pre><code class="language-bash">php beaver queue:failed              # lista jobs que esgotaram as tentativas
php beaver queue:retry 5             # tenta de novo o job com ID 5
php beaver queue:retry --all         # tenta de novo todos os falhados
php beaver queue:flush               # apaga o histórico de falhados</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-flag-checkered"></i>Exemplo real completo — processar upload de imagem</h2>
    <div class="beaver-card">
        <p class="mb-2">Cenário: o utilizador faz upload de uma foto de perfil; redimensionar para 3 tamanhos é lento, por isso vai para uma fila.</p>

        <p class="mb-1 fw-bold">1. Job</p>
        <pre><code class="language-php">namespace App\Jobs;

use Beaver\Queue\Job;
use App\Models\User;
use Intervention\Image\ImageManager;

class ResizeAvatarJob extends Job
{
    public int $tries = 2;

    public function __construct(
        private readonly int $userId,
        private readonly string $originalPath
    ) {}

    public function handle(): void
    {
        $manager = new ImageManager();
        $sizes = ['thumb' => 64, 'medium' => 256, 'large' => 512];

        foreach ($sizes as $label => $size) {
            $image = $manager->read(storage_path("app/{$this->originalPath}"));
            $image->cover($size, $size);
            $image->save(storage_path("app/avatars/{$this->userId}-{$label}.jpg"));
        }

        User::query()->where('id', $this->userId)->update(['avatar_processed' => true]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("Falha ao processar avatar do user {$this->userId}: {$exception->getMessage()}");
    }
}</code></pre>

        <p class="mt-3 mb-1 fw-bold">2. Controller — recebe o upload e despacha o job</p>
        <pre><code class="language-php">namespace App\Controllers;

use App\Jobs\ResizeAvatarJob;
use Beaver\Http\Request;
use Beaver\Http\Response;

class ProfileController
{
    public function updateAvatar(Request $request): Response
    {
        $request->validate([
            'avatar' => 'required|image|max:5120', // 5MB
        ]);

        $path = $request->file('avatar')->store('uploads/originals');

        ResizeAvatarJob::dispatch($request->user()->id, $path)
            ->onQueue('images');

        return redirect('/perfil')->with('info', 'A tua foto está a ser processada, atualiza a página em breve.');
    }
}</code></pre>

        <p class="mt-3 mb-1 fw-bold">3. Rota</p>
        <pre><code class="language-php">Route::post('/perfil/avatar', [ProfileController::class, 'updateAvatar'])->middleware('auth');</code></pre>

        <p class="mt-3 mb-1 fw-bold">4. Correr</p>
        <pre><code class="language-bash">php beaver migrate
php beaver queue:work --queue=images
# noutro terminal:
php beaver serve</code></pre>
        <p class="mt-2 mb-0 text-muted small">
            O pedido HTTP do upload responde de imediato (o utilizador não espera pelo redimensionamento);
            o worker vai buscar o job à fila <code class="inline-code">images</code> e processa-o em paralelo.
        </p>
    </div>
</section>

<?php require __DIR__ . '/partials/foot.php'; ?>

