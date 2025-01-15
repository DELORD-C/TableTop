# TableTop

A [Docker](https://www.docker.com/)-based virtual TableTop made with the [Symfony](https://symfony.com) web framework,
with [FrankenPHP](https://frankenphp.dev) and [Caddy](https://caddyserver.com/) inside !

Credits for symfony docker base goes to [@dunglas](https://github.com/dunglas/symfony-docker)

## Getting Started

### Docker

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh image
3. Run `docker compose up --pull always -d --wait` to start the project
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Open `https://localhost:8081` in your favorite web browser to access phpmyadmin (root:root)
6. Run `docker compose down --remove-orphans` to stop the Docker containers.

#### Running in production mode

1. Update .env with
```dotenv
SERVER_NAME=your-domain-name.example.com
APP_SECRET=ChangeMe
CADDY_MERCURE_JWT_SECRET=ChangeThisMercureHubJWTSecretKey
```
2. Run `docker compose -f compose.yaml -f compose.prod.yaml up -d --wait`

### Symfony CLI

#### Requirements

- [PHP](https://www.php.net/) 7.4 or higher
- [Symfony CLI](https://symfony.com/doc/current/cli.html) or higher
- [Composer](https://getcomposer.org/)
- [NPM](https://nodejs.org/en/download/) (or [Yarn](https://yarnpkg.com/))
- [MySQL](https://www.mysql.com/) (or another compatible database)

#### Usage

1. Update .env with your own values
2. Run `composer install`
3. Run `symfony console doctrine:database:create`
4. Run `php bin/console doctrine:migrations:migrate`
5. Run `npm install`
6. Run `npm run dev` (or `npm run build` for production | or `npm run watch` for listening)
7. Run `symfony server:ca:install`
8. Run `symfony server:start` (or `symfony serve`)