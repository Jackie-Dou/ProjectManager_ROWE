in-db:
	psql -Uwanuser -dtaskmanager

start:
	php artisan serve --host 127.0.0.1

lint:
	composer run-script phpcs -- --standard=PSR12 tests app

fix:
	composer run-script phpcbf -- app

install:
	composer install

start-db:
	sudo service postgresql start

check-db:
	ps aux | grep postgres

migrate:
	php artisan migrate

console:
	php artisan tinker

deploy:
	git push heroku main

test:
	php artisan test

setup:
	composer install
	cp -n .env.example .env || true
	php artisan key:gen --ansi
	php artisan migrate
	php artisan db:seed
	npm install

setup-not-full:
	composer install
	cp -n .env.example .env || true
	php artisan key:gen --ansi
	npm install
