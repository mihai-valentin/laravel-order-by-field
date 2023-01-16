build: composer.lock test

composer.lock: composer.json
	composer install

test: phpunit src-phpstan cs-fixer

phpunit: phpunit-unit phpunit-feature phpunit-integration

phpunit-unit:
	vendor/bin/phpunit --testsuite=Unit

phpunit-feature:
	vendor/bin/phpunit --testsuite=Feature

phpunit-integration:
	vendor/bin/phpunit --testsuite=Integration

src-phpstan:
	vendor/bin/phpstan analyse src --xdebug

cs-fixer:
	vendor/bin/php-cs-fixer fix -v src/

coverage-report:
	vendor/bin/phpunit --coverage-filter=src --coverage-html=./phpunit-coverage-report
