#!/usr/bin/env bash
set -e
cd "$(dirname "$0")"

STAMP=$(date +%Y%m%d-%H%M%S)
mkdir -p reports

# deteta se há cobertura disponível
if php -m | grep -qiE "xdebug|pcov"; then
    COVERAGE="--coverage-html reports/coverage-html --coverage-text"
else
    COVERAGE=""
    echo "Aviso: sem xdebug/pcov. Cobertura não será gerada."
fi

vendor/bin/phpunit \
  --log-junit "reports/junit-$STAMP.xml" \
  $COVERAGE \
  2>&1 | tee "reports/test-$STAMP.txt"

echo
echo "Relatórios em: reports/"
