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

// app/Commands/CertifyCheckCommand.php

namespace App\Commands;

use Beaver\Console\Command;
use Beaver\Certify\CertificateManager;

class CertifyCheckCommand extends Command
{
    protected string $signature = 'certify:check
        {domain? : Dominio a verificar}
        {--all : Verificar todos os certificados}';

    protected string $description = 'Verifica a saude dos certificados TLS';

    public function handle(): int
    {
        $configPath = dirname(__DIR__, 2) . '/config/certify.php';
        $config = file_exists($configPath) ? require $configPath : [];

        $manager = new CertificateManager($config);

        if ($this->option('all')) {
            $certs = $manager->list();
            if (empty($certs)) {
                $this->warning('Nenhum certificado encontrado.');
                return self::SUCCESS;
            }
            foreach ($certs as $cert) {
                $this->renderCert($cert);
            }
            return self::SUCCESS;
        }

        $domain = $this->argument('domain');
        if (!$domain) {
            $this->error('Indica um dominio ou usa --all');
            return self::FAILURE;
        }

        $this->renderCert($manager->check($domain));
        return self::SUCCESS;
    }

    private function renderCert(array $cert): void
    {
        if (!($cert['valid'] ?? false)) {
            $this->error("{$cert['domain']}  -  " . ($cert['error'] ?? 'invalido'));
            return;
        }

        $this->line("OK  {$cert['domain']}  -  {$cert['days_remaining']} dias  -  {$cert['issuer']}");
    }
}
