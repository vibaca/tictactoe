composer-install:
	docker-compose exec -u $(shell id -u):$(shell id -g) php composer install --dev
.PHONY: composer-

phpunit:
	docker-compose exec -u $(shell id -u):$(shell id -g) php vendor/bin/phpunit tests
.PHONY: phpunit