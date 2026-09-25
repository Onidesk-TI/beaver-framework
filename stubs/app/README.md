# {{ APP_NAME }}

Aplicação criada com [Beaver Framework](https://github.com/Frank-Onidesk/beaver-framework).

## Requisitos

- PHP 8.1+
- Composer 2.x
- Extensões: `pdo_sqlite` (ou `pdo_mysql` / `pdo_pgsql`), `openssl`, `json`

## Arrancar

    composer install
    cp .env.example .env
    ./beaver key:generate
    ./beaver migrate
    ./beaver serve

Depois abre http://localhost:9000

## Estrutura

    app/            → controllers, models, middleware
    config/         → configuração
    database/       → migrations, seeders
    public/         → entry-point HTTP
    resources/views → templates
    routes/         → definição de rotas
    storage/        → cache, logs, sessões, sqlite
    tests/          → testes PHPUnit

## Comandos úteis

    ./beaver help               → lista todos os comandos
    ./beaver serve              → arranca servidor de dev
    ./beaver migrate            → corre migrations
    ./beaver make:controller X  → cria controller
    ./beaver make:middleware X  → cria middleware
    ./beaver make:model X       → cria model + migration
    ./beaver test               → corre testes

## Documentação

- Documentação oficial: `/documentation`
- Comandos CLI: `/commands`
- Versões: `/versions`
- Manual: `/manual`
