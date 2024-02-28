build:
	@docker compose build

up:
	@docker compose up -d

stop:
	@docker compose stop

restart:
	@make stop
	@make up

php:
	@docker compose exec -it php bash

mysql:
	@docker compose exec -it mysql bash

npm-i:
	@npm install

npm-dev:
	@npm run dev

npm-build:
	@npm run build

env:
ifeq (,$(wildcard .env))
	cp .env.example .env
endif

composer-i:
	@docker compose exec php composer install

migrate:
	@docker compose exec php php artisan migrate

migrate-rollback:
	@docker compose exec php php artisan migrate:rollback

key-generate:
	@docker compose exec php php artisan key:generate

init:
	@make env
	@make build
	@make up
	@make npm-i
	@make composer-i
	@make key-generate
	@make restart
	@make migrate
	@make npm-build
