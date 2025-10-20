# Requirements

* PHP 8.1
* Composer
* Symfony CLI
* Docker
* Docker-compose
* nodejs npm yarn

## Install

```bash
composer install
yarn install
yarn encore dev
docker-compose up -d
symfony serve -d
```

## Populate the database

```bash
symfony console doctrine:migration:migrate --env=dev --no-interaction
symfony console doctrine:fixtures:load --no-interaction
```

## Testing account

Username: R.BACHEL
Password: 123

Or create a new one in app (Abonnez-vous)

## Unit and Functional tests

```bash
APP_env=test symfony php -dxdebug.mode=coverage bin/phpunit --coverage-html var/log/test/test-coverage
```
