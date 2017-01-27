#!/usr/bin/env bash

non_breakable_space=" "
lines_with_errors=$(grep -r $non_breakable_space ./src ./database)

if [[ ${lines_with_errors} ]]; then
    echo "You have non-breakable spaces, please remove them"
    echo "$lines_with_errors"
    exit 1
else
    exit 0
fi