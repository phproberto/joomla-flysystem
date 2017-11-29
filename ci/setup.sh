#!/bin/bash

# Clone current joomla & install composer there
git clone https://github.com/joomla/joomla-cms.git /tmp/joomla-cms
composer install -d /tmp/joomla-cms

# Install joomla-twig testing composer dependencies
composer install --prefer-dist --no-interaction --no-progress
