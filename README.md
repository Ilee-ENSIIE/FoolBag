# source project bashrc
source .bashrc

# database commands
composer db.up     # start the database create custom user and database, setup app schema
composer db.down   # drop everything custom and stop the database
composer db.reset  # shortcut for db.up && db.down
composer db.shell  # connects to the database commands (TODO)

# setup project
composer project.setup (TODO)