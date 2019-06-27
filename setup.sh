#!/bin/bash
cp -v docker-compose.example.yml docker-compose.yml
echo 'Running the system and building a new image if necessary'
docker-compose up -d
echo 'Running composer install'
docker exec -it -u 0 php-tititi composer install
echo 'Opening the docker php container'
docker exec -it -u 0 php-tititi bash