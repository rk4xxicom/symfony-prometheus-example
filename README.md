What this is about
==========

This is a demo project for 3 ways you can integrate Prometheus / OpenMetrics in your Symfony application. 
The app has 3 endpoints available for monitoring:

1. http://localhost/legacy/metrics - using sql
2. http://localhost:3903/metrics - via mtail
3. http://localhost/prometheus/metrics - using bundle

The app has 2 tables: bank accounts and users and include a prometheus config.

Prometheus is available on http://localhost:9090

Installation Instructions
==========

## Requirements

* [Docker and Docker Compose](https://docs.docker.com/engine/installation)

## Configuration

Application configuration is stored in `.env` file. 

Run `cp .env.dist .env` to apply the default configuration for local installations.

### HTTP port
If you have nginx or apache installed and using 80 port on host system you can either stop them before proceeding or 
reconfigure Docker to use another port by changing value of `EXTERNAL_HTTP_PORT` in `.env` file.

### Application environment
You can change application environment to `dev` of `prod` by changing `APP_ENV` variable in `.env` file.

### DB name and credentials
DB name and credentials could by reconfigured by changing variables with `POSTGRES` prefix in `.env` file. It is 
recommended to restart containers after changing these values (new database will be automatically created on containers 
start).

## Installation

### 1. Start Containers and install dependencies 
On Linux:
```bash
docker-compose up -d
```
### 2. Run migrations, install fixtures
```bash
docker-compose exec php bin/console doctrine:migrations:migrate
docker-compose exec php bin/console doctrine:fixtures:load
```

### 4. Open project
Just go to http://localhost/legacy/metrics


Application commands
==========

Creating a user:
`curl -X POST http://localhost/user -d name=testusername`
