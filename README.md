# Converting PDF to Image using PHP

## Task

Build an app that will convert a PDF files to an image.

## Requirements

- Each page in the PDF file must be converted to an image
- Delete the PDF file after processing it
- Name the image using invoice number
- Must run on PHP 5.3 server
- Be mindful of CPU load

## Technology stack used in this project

- Docker version 20.10.20
- PHP version 5.3.29
- Xdebug v2.2.7
- cron
- PHPStorm (IDE)

## Set Environment

Copy .env.example to .env and make the following changes to the .env file:

- Environment
    - DB_HOST=mysql
    - DB_PORT=3306
    - DB_DATABASE=example_db
    - DB_USERNAME=example_user
    - DB_PASSWORD=example_password
    - HTTP_PORT=80

## Install dependencies

Your can run the following command to install the dependencies.

```bash
docker-compose build
```

## Run the app

1. Start the docker containers

```bash
docker-compose up -d
```

2. Run script

```bash
docker-compose run php php /var/www/html/src/convert_pdf_files.php
```

You can also connect to the container and run the script:

Connect to the container

```bash
docker-compose exec php /bin/bash
```

Run the script:

```bash
php /var/www/html/src/convert_pdf_files.php
```

## Tear down the containers

To tear down the containers use the command:

```bash
docker-compose down --rmi all -v
```
