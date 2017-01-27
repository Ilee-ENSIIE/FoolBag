# source project bashrc
. .bashrc

# install php7.1
./infra/php7install.sh

# install dependencies
composer install

# database commands
composer db.up      # start the database create custom user and database, setup app schema
composer db.down    # drop everything custom and stop the database
composer db.reset   # shortcut for db.up && db.down
./database/psql.sh  # connects to the database commands

# testing
composer test            # run full test suite
composer test.unit       # run unit tests
composer test.lint       # php md && php cs (TODO)
composer test.lint.fix   # php cs-fixer (TODO)

# setup project
composer project.setup (TODO)


TODO:
- add dependencies test