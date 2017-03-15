# source project bashrc
```
. .bashrc
```

# setup project
```
composer project.setup
```

# database commands
```
composer db.up      # start the database create custom user and database, setup app schema
composer db.down    # drop everything custom and stop the database
composer db.reset   # shortcut for db.up && db.down
./database/psql.sh  # connects to the database commands
```

# testing
```
composer test                # run unit tests, code smells, mess detector and dependencies check
composer test.unit           # run unit tests
composer test.lint           # php code sniffer (cs)
composer test.lint.fix       # php cs-fixer
composer test.md             # php mess detector (md)
composer test.dependencies   # check for outdated external dependencies
composer dump-autoload       # re-dump autoload
```

# debugging
```
composer logs
```