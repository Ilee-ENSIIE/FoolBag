#!/bin/sh

# theses command will fail the second time you call them
psql -c "drop database tp_web;" 2> /dev/null
psql -c "drop user tp_web;" 2> /dev/null
