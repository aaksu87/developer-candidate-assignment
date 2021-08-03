init:
	docker-compose build --force-rm --no-cache
	make up

up:
	docker-compose up -d
	echo "App is running at http://127.0.0.1:8030"

down:
	docker-compose down -v --remove-orphans

schema-update:
	docker exec -it library /home/library/bin/console doctrine:database:create --if-not-exists
	docker exec -it library /home/library/bin/console doctrine:schema:update --force

schema-create-test:
	docker exec -it library /home/library/bin/console --env=test doctrine:database:create --if-not-exists
	docker exec -it library /home/library/bin/console --env=test doctrine:schema:create

install-fixtures-dev:
	composer require orm-fixtures --dev

load-fixtures:
	docker exec -it library /home/library/bin/console doctrine:fixtures:load

load-fixtures-test:
	docker exec -it library /home/library/bin/console --env=test doctrine:fixtures:load

install-security-jwt:
	composer require lexik/jwt-authentication-bundle

generate-security-keypair:
	bin/console lexik:jwt:generate-keypair

install-monolog:
	composer require symfony/monolog-bundle

cs-fix:
	vendor/bin/php-cs-fixer fix --allow-risky yes --config=.php-cs-fixer.dist.php

code-coverage:
	bin/phpunit -v --coverage-html coverage-html