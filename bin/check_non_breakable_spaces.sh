#!/usr/bin/env bash
lines_with_errors=$(grep -rnP "\xA0" src database)

if [[ ${lines_with_errors} ]]; then
    echo "You have non-breakable spaces, please remove them"
    echo "$lines_with_errors"
    exit 1
else
    exit 0
fi