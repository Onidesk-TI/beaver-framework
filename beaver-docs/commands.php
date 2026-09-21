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
$pageTitle = 'Commands (CLI Custom)';
$pageSubtitle = 'Criar comandos de terminal próprios para a tua aplicação';
$activeSlug = 'commands';
require __DIR__ . '/partials/head.php';
?>
<section class="beaver-section">
    <h2><i class="fas fa-terminal"></i>Criar um Command</h2>
    <div class="beaver-card">
        <pre><code class="language-bash">php beaver make:command SendNewsletterCommand</code></pre>
        <pre><code class="language-php">namespace App\Commands;

use Beaver\Console\Command;
use App\Models\Subscriber;
use App\Mail\NewsletterMail;

class SendNewsletterCommand extends Command
{
    protected string $signature = 'newsletter:send {--dry-run : Não envia, só simula}';
    protected string $description = 'Envia a newsletter semanal a todos os subscritores ativos';

    public function handle(): int
    {
        $subscribers = Subscriber::query()->where('active', true)->get();

        $this->info("A enviar para {$subscribers->count()} subscritores...");

        foreach ($subscribers as $subscriber) {
            if (! $this->option('dry-run')) {
                Mail::to($subscriber->email)->send(new NewsletterMail());
            }
            $this->line("  ✓ {$subscriber->email}");
        }

        $this->info('Concluído!');
        return self::SUCCESS;
    }
}</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-list-check"></i>Registar o comando</h2>
    <div class="beaver-card">
        <p class="mb-2">Comandos dentro de <code class="inline-code">app/Commands/</code> são descobertos automaticamente. Para os agrupar/documentar, podes também listá-los em <code class="inline-code">routes/console.php</code>:</p>
        <pre><code class="language-php">use App\Commands\SendNewsletterCommand;

Console::command(SendNewsletterCommand::class);</code></pre>
        <pre><code class="language-bash">php beaver newsletter:send
php beaver newsletter:send --dry-run
php beaver list                 # lista todos os comandos disponíveis</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-clock"></i>Agendamento (Scheduler)</h2>
    <div class="beaver-card">
        <p class="mb-2"><code class="inline-code">routes/console.php</code>:</p>
        <pre><code class="language-php">use Beaver\Console\Schedule;

Schedule::command('newsletter:send')->weekly()->mondays()->at('08:00');
Schedule::command('cache:clear')->daily();
Schedule::command('security:scan')->hourly();</code></pre>
        <pre><code class="language-bash"># Cron único a apontar para o scheduler do Beaver
* * * * * php /caminho/para/o/projeto/beaver schedule:run >> /dev/null 2>&1</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-comments"></i>Input interativo</h2>
    <div class="beaver-card">
        <pre><code class="language-php">$nome = $this->ask('Qual o nome do novo módulo?');
$confirma = $this->confirm('Tens a certeza?', false);
$opcao = $this->choice('Ambiente', ['local', 'staging', 'production'], 0);

$this->table(['ID', 'Nome'], [[1, 'Artigo A'], [2, 'Artigo B']]);
$this->progressBar(100, function ($bar) {
    // ... trabalho, $bar->advance() em cada iteração
});</code></pre>
    </div>
</section>

<?php require __DIR__ . '/partials/foot.php'; ?>
