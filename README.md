# Tititi is a component

## Running as local environment

- Run
    ````
    chmod +x setup.sh && ./setup.sh
    ````

- Run
    ````
    php src/examples/redis/RedisConsumerExample.php
    ````

- Open a new terminal tab and run
    ````
    docker exec -it -u 0 php-tititi bash
    php src/examples/redis/RedisPublishExample.php
    ````