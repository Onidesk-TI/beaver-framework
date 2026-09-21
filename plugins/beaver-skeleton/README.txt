========================================================================
  BEAVER SKELETON
  Esqueleto oficial para criar plugins para o Beaver Framework
========================================================================

License : MIT
PHP     : >= 8.1
Type    : beaver-plugin
Repo    : https://github.com/Onidesk-TI/beaver-console

------------------------------------------------------------------------
  O QUE É
------------------------------------------------------------------------

Um plugin base pronto a clonar para criares o teu próprio plugin Beaver
em segundos. Traz:

  - Manifest (plugin.json)
  - Composer (type: beaver-plugin)
  - Classe principal (extends PluginBase)
  - Rotas com assets (/plugins/beaver-skeleton/css|js)
  - View de exemplo
  - CSS + JS no tema âmbar/castanho

------------------------------------------------------------------------
  INSTALAÇÃO RÁPIDA
------------------------------------------------------------------------

  # 1. Clonar para o teu plugin
  git clone https://github.com/Onidesk-TI/beaver-console.git meu-plugin
  cd meu-plugin

  # 2. Renomear (substituir "Skeleton" pelo teu nome)
  #    ver secção "Renomear" abaixo

  # 3. Instalar
  composer install

------------------------------------------------------------------------
  ESTRUTURA
------------------------------------------------------------------------

  beaver-skeleton/
  ├── plugin.json                # manifest do plugin
  ├── composer.json              # autoload + type: beaver-plugin
  ├── README.md
  ├── HELP.md
  ├── LICENSE
  ├── .gitignore
  ├── .editorconfig
  ├── routes/
  │   └── web.php                # rotas do plugin
  ├── src/
  │   └── SkeletonPlugin.php     # classe principal
  ├── resources/
  │   ├── views/
  │   │   └── index.php          # view de exemplo
  │   └── ui/
  │       ├── css/               # CSS
  │       └── js/                # JS
  └── tests/
      └── PluginTest.php

------------------------------------------------------------------------
  RENOMEAR PARA O TEU PLUGIN
------------------------------------------------------------------------

  Substitui em todos os ficheiros:

    De                              Para
    ------------------------------  ------------------------------
    Skeleton                        MeuPlugin
    skeleton                        meu-plugin
    Beaver\Plugins\Skeleton         Beaver\Plugins\MeuPlugin
    onidesk/beaver-skeleton         onidesk/beaver-meu-plugin

  Comando rápido (Linux/macOS):

    grep -rl "Skeleton" . | xargs sed -i 's/Skeleton/MeuPlugin/g'
    grep -rl "skeleton" . | xargs sed -i 's/skeleton/meu-plugin/g'

------------------------------------------------------------------------
  ASSETS
------------------------------------------------------------------------

  Os assets são servidos pelo router do plugin:

    URL                              Ficheiro
    -------------------------------  --------------------------------
    /plugins/beaver-skeleton/css/<file>     resources/ui/css/<file>
    /plugins/beaver-skeleton/js/<file>      resources/ui/js/<file>

------------------------------------------------------------------------
  TESTES
------------------------------------------------------------------------

  vendor/bin/phpunit

------------------------------------------------------------------------
  DOCUMENTAÇÃO
------------------------------------------------------------------------

  Vê o HELP.md para detalhes de desenvolvimento.

------------------------------------------------------------------------
  LICENÇA
------------------------------------------------------------------------

  MIT © Onidesk
========================================================================
