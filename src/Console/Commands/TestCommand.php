<?php

declare(strict_types=1);

namespace Beaver\Console\Commands;

use Beaver\Console\Command;

class TestCommand extends Command
{
    protected string $signature = 'test {--filter=} {--parallel}';
    protected string $description = 'Corre os testes do projeto (PHPUnit)';

    public function handle(): int
    {
        $phpunit = $this->projectPath . '/vendor/bin/phpunit';
        $config  = $this->projectPath . '/phpunit.xml';

        if (!is_file($phpunit)) {
            $this->error('PHPUnit não está instalado.');
            $this->line();
            $this->info('Para instalar:');
            $this->line('  composer require --dev phpunit/phpunit');
            $this->line();
            $this->info('Ou adiciona ao composer.json:');
            $this->line('  "require-dev": {');
            $this->line('    "phpunit/phpunit": "^11.0"');
            $this->line('  }');
            $this->line();
            $this->warning('Depois: composer install && phpunit.xml na raiz do projeto.');
            return self::FAILURE;
        }

        $args = [];

        if ($config && is_file($config)) {
            $args[] = '--configuration ' . escapeshellarg($config);
        }

        if ($filter = $this->option('filter')) {
            $args[] = '--filter ' . escapeshellarg((string) $filter);
        }

        if ($this->option('parallel')) {
            $this->warning('--parallel requer paraatest/paratest instalado. A ignorar.');
        }

        $cmd = escapeshellarg($phpunit) . ' ' . implode(' ', $args);

        $this->line();
        $this->info('🧪 Beaver — Testes');
        $this->line("  Comando: {$cmd}");
        $this->line();

        passthru($cmd, $code);

        $this->line();
        if ($code === 0) {
            $this->success('Todos os testes passaram');
        } else {
            $this->error("PHPUnit devolveu código {$code}");
        }

        return $code === 0 ? self::SUCCESS : self::FAILURE;
    }
}
