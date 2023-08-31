#!/bin/bash

# Set the path to the MAMP PHP binary
MAMP_PHP_PATH="/Applications/MAMP/bin/php/php7.4.33/bin/php"

# Composer command
$MAMP_PHP_PATH /usr/local/bin/composer update --ignore-platform-reqs

