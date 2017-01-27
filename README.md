# source project bashrc
. .bashrc

# database commands
composer db.up      # start the database create custom user and database, setup app schema
composer db.down    # drop everything custom and stop the database
composer db.reset   # shortcut for db.up && db.down
./database/psql.sh  # connects to the database commands (TODO)

# testing
composer test            # run full test suite
composer test.unit       # run unit tests
composer test.lint       # php md && php cs
composer test.lint.fix   # php cs-fixer

# setup project
composer project.setup (TODO)


TODO:
- use PHP7 (scalar type hints && return hints): https://github.com/c9/templates/pull/49
- use latest version of phpunit
- add dependencies test