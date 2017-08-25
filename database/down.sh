#!/bin/sh

# theses command will fail the second time you call them
psql -c "drop database BagTrip;" 2> /dev/null
psql -c "drop user admin;" 2> /dev/null
