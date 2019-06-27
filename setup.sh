#!/bin/bash
cp -v docker-compose.example.yml docker-compose.yml
docker-compose up -d
docker exec -it -u 0 php-tititi bash