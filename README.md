# News Aggregator - Backend Laravel API

News Aggregator is a project for pulling articles from various sources, and for trying the new version of Laravel v10.x

## How to use

First you need to clone the project using the following commmand:

```shell
git clone https://github.com/abdulrahmanKanakri/backend-laravel-api.git
```

Then you should install the required dependencies using the following command:

```shell
composer install
```

To run the project in development mode, first copy the .env file using the following command:

```shell
cp .env.example .env
```

Second, run the migration then run the server using the following commands:

```shell
# run the migration
php artisan migrate:refresh --seed

# run the server
php artisan serve
```

To run the project in production mode, first you should create .env file for production by running the command:

```shell
cp .env.example .env.production
```

Second, run the project using docker compose by running the following command:

```shell
docker compoes up --build
```

## Used APIs

- [News API](https://newsapi.org/docs/get-started)
- [New York Times](https://developer.nytimes.com/apis)
- [The Guardian](https://open-platform.theguardian.com/documentation/)
