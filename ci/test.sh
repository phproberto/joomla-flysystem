#!/bin/bash
./vendor/bin/phpcs
./vendor/bin/phpunit -c ./phpunit.ci.xml
