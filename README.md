# source project bashrc
source .bashrc

# setup database
composer db.start     # start the database
composer db.setup     # create custom user and database, setup app schema

# setup project
composer project.setup