PHP_CONTAINER = php.studio_flag
MYSQL_CONTAINER = mysql.studio_flag
PACKAGE_MANAGER := $(shell \
	if command -v apt-get > /dev/null; then echo apt; \
	elif command -v dnf > /dev/null; then echo dnf; \
	elif command -v yum > /dev/null; then echo yum; \
	elif command -v pacman > /dev/null; then echo pacman; \
	elif command -v zypper > /dev/null; then echo zypper; \
	elif command -v brew > /dev/null; then echo brew; \
	elif command -v apk > /dev/null; then echo apk; \
	else echo unknown; fi)

.PHONY = help install db install-dependencies init-db seed-db build up down delete

include .env
export

help:
	@echo "make install  - Установить проект локально"
	@echo "make up       - Запустить проект"
	@echo "make down     - Остановить проект"
	@echo "make delete   - Удалить проект"

install:
	$(MAKE) install-dependencies
	composer install
	$(MAKE) build

install-dependencies:
	sudo ${PACKAGE_MANAGER} install -y php docker docker-compose composer

build:
	composer install
	docker compose up --build

up:
	docker compose up

down:
	docker compose down

delete:
	docker compose down -v

detect-package-manager:
	@echo "$(PACKAGE_MANAGER)"

commit:
	git add .
	git commit -m "$(m)"
	git push -u origin main

enter-db:
	docker exec -it $(MYSQL_CONTAINER) mysql -u$(DB_USERNAME) -p$(DB_PASSWORD) $(DB_DATABASE)

migrations:
	docker exec -i $(PHP_CONTAINER) php artisan migrate
