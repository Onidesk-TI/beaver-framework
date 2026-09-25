# Beaver Framework

Framework PHP moderno com ecossistema de plugins.

**Versao:** v0.3.0 | **PHP:** >=8.1 | **Licenca:** MIT

---

## Indice

- O que e
- Requisitos
- Instalacao
- Estrutura do projeto
- CLI (comandos)
- Configuracao (.env)
- Rotas
- Controllers e views
- Middleware
- Base de dados
- Plugins
- Temas
- Sistema de versoes
- Documentacao web
- Testes
- Licenca

---

## O que e

O Beaver e um framework PHP moderno, sem dependencias externas obrigatorias,
pensado para ser simples de instalar, rapido de iterar e facil de estender
atraves de plugins.

**Destaques**

- Zero-config: um `composer install` e esta pronto.
- CLI completo com 27 comandos.
- Esqueleto de app: `./beaver install --new=myapp` cria um projeto do zero.
- Sistema de plugins com manifestos e permissoes.
- SDK de temas com fallback automatico.
- Versao dinamica lida de uma unica fonte (composer.json).
- Documentacao web integrada em /documentation, /commands, /versions, /manual.

---

## Requisitos

- PHP >= 8.1
- Composer >= 2.0
- Extensoes: pdo, json, openssl
- Driver de BD: pdo_sqlite, pdo_mysql ou pdo_pgsql

---

## Instalacao

### Criar um novo projeto

O comando `install` cria um projeto novo a partir do esqueleto oficial:

```bash
./beaver install --new=myapp
./beaver install --new=myapp --path=/var/www
```

Isto cria:

- Estrutura completa em myapp/
- composer.json com beaver/framework: ^0.3
- .env com APP_KEY gerada
- Corre composer install automaticamente

Flags:

- `--no-install` - nao corre composer install
- `--no-key` - nao gera APP_KEY
- `--force` - sobrepoe pasta existente

### Clonar o framework diretamente

```bash
git clone https://github.com/Frank-Onidesk/beaver-framework
cd beaver-framework
composer install
cp .env.example .env
php beaver migrate
php beaver serve
```

Depois abre http://localhost:9000

---

