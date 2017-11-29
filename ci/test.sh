#!/bin/bash
./vendor/bin/phpcs
./vendor/bin/phpunit -c ./ci/phpunit.ci.xml
