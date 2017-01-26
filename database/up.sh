#!/bin/sh
BASEDIR=$(dirname "$0")

# theses command will fail the second time you call them
psql -c "create user tp_web with encrypted password 'tp_web';" 2> /dev/null
psql -c "create database tp_web with owner tp_web;" 2> /dev/null

# check the postgresql connection using custom user
PGPASSWORD=tp_web psql -U tp_web -h localhost tp_web -t -c "select '✓ postgres connection';"

# run custom script
PGPASSWORD=tp_web psql -U tp_web -h localhost -t -f $BASEDIR/schema.sql tp_web


