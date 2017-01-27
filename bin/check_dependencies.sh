#!/usr/bin/env bash

outdated_dependencies=$(php composer.phar outdated --direct)

if [[ ${outdated_dependencies} ]]; then
    echo "Dependencies outdated"
    echo "$outdated_dependencies"
    exit 1
else
    exit 0
fi