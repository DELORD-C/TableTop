# TableTop

A [Docker](https://www.docker.com/)-based virtual TableTop made with the [Symfony](https://symfony.com) web framework,
with [FrankenPHP](https://frankenphp.dev) and [Caddy](https://caddyserver.com/) inside !

Credits for symfony docker base goes to [@dunglas](https://github.com/dunglas/symfony-docker)

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up --pull always -d --wait` to start the project
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Open `https://localhost:8081` in your favorite web browser to access phpmyadmin (root:root)
6. Run `docker compose down --remove-orphans` to stop the Docker containers.

## Running in production mode

1. Update .env with
```dotenv
SERVER_NAME=your-domain-name.example.com
APP_SECRET=ChangeMe
CADDY_MERCURE_JWT_SECRET=ChangeThisMercureHubJWTSecretKey
```
2. Run `docker compose -f compose.yaml -f compose.prod.yaml up -d --wait`