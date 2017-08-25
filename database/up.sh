#!/bin/sh
BASEDIR=$(dirname "$0")

# theses command will fail the second time you call them
psql -c "create user admin with encrypted password 'admin';" 2> /dev/null
psql -c "create database BagTrip with owner admin;" 2> /dev/null

# check the postgresql connection using custom user
PGPASSWORD=admin psql -U admin -h localhost BagTrip -t -c "select '✓ postgres connection';"

# run custom script
PGPASSWORD=admin psql -U admin -h localhost -t -f $BASEDIR/schema.sql BagTrip



