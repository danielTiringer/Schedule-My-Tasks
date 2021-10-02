# Task Scheduler - Todo list style app for personal use

Looking to write an application that helps keep on top of the daily tasks.

## Learnings

- Using **CodeIgniter** for this project (no previous experience with the framework)
- Make a dockerized development environment with **Apache** and **MySQL**
- Use various features
- Set up a CI/CD pipeline in a system I'm not familiar with yet (using **Gitlab** CI pipeline with a **Github** repository)

## Usage

A dockerized development environment for a CodeIgniter application. It comes with a webserver, a database and a database manager tool as well.

### Install Docker

To get started, make sure you have Docker installed on your system, and then clone this repository.

### Create a CodeIgniter app

Creating a new CodeIgniter application is handled by spinning up a Docker container to generate it.
Find the details about CodeIgniter applications on the [CodeIgiter Framework documentation site](https://codeigniter4.github.io/userguide/installation/index.html).

``` sh
docker-compose run --rm php composer create-project codeigniter4/appstarter .
```

#### Connect to a database

In order to connect to a database, first copy the `src/env` file to `src/.env`, then uncomment and change the following:

``` env
database.default.hostname = database
database.default.database = database
database.default.username = user
database.default.password = password
database.default.DBDriver = MySQLi
```

### Start the containers

From the respository's root run `docker-compose up -d --build`. Open up your browser of choice to [http://localhost:4200](http://localhost:4200) and you should see the app running as intended.

Containers created and their ports (if used) are as follows:

- **php** - `:4200`
- **mariadb** - `:3306`
- **phpmyadmin** - `:4300`

### Run command line commands

Use the following command templates from your project root, modifiying them to fit your particular use case:

``` sh
docker-compose run --rm php composer update
docker-compose run --rm php php spark migrate:status
docker-compose run --rm php vendor/bin/phpunit --colors tests/
```

You can also run cli-based commands (courtesy of CodeIgniter) for crons and other purposes either from within the container (then omit the docker part), or from outside:

``` sh
docker-compose run --rm php php public/index.php <INSERT ROUTE WORD BY WORD>
```

### Troubleshooting

- Make sure the `DBDriver` specified in the database config is actually installed in the **php**  container
- Make sure the `writable` folder is set to be writable (`chmod -R 777 src/writable`)

### Resources

- [CodeIgniter documentation](https://codeigniter.com/user_guide/index.html)
