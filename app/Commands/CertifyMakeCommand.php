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
// app/Commands/CertifyMakeCommand.php

namespace App\Commands;

use Beaver\Console\Command;
use Beaver\Certify\CertificateManager;

class CertifyMakeCommand extends Command
{
    protected string $signature = 'certify:make
        {domain : Dominio do certificado}
        {--days=365 : Validade em dias}
        {--key-size=2048 : Tamanho da chave}
        {--force : Sobrescrever se ja existir}';

    protected string $description = 'Gera certificado self-signed para desenvolvimento';

    public function handle(): int
    {
        $domain = $this->argument('domain');

        if (!$domain) {
            $this->error('Falta o dominio. Uso: php beaver certify:make meu-app.local');
            return self::FAILURE;
        }

        $configPath = dirname(__DIR__, 2) . '/config/certify.php';
        $config = file_exists($configPath) ? require $configPath : [];

        $manager = new CertificateManager($config);

        try {
            $cert = $manager->makeSelfSigned(
                domain:  $domain,
                days:    (int) $this->option('days', 365),
                keySize: (int) $this->option('key-size', 2048),
                force:   (bool) $this->option('force', false),
            );

            $this->success('Certificado gerado com sucesso');
            $this->line("   Dominio:  {$cert->domain()}");
            $this->line("   Expira:   {$cert->expiresAt()->format('Y-m-d')} ({$cert->daysRemaining()} dias)");
            $this->line("   CRT:      {$cert->crtPath()}");
            $this->line("   KEY:      {$cert->keyPath()}");

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }
    }
}
