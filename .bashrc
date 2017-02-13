alias composer="php composer.phar"

git config --global alias.co checkout
git config --global alias.br branch
git config --global alias.ci commit
git config --global alias.st status

# composer default timeout is too short when tailing logs
export COMPOSER_PROCESS_TIMEOUT=10000