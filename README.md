# Tititi is a component

## Running in a local environment

- Run the script below to up the system
    ````
    chmod +x setup.sh && ./setup.sh
    ````

- Run (inside the PHP container)
    ````
    php src/examples/redis/RedisConsumerExample.php
    ````

- Open a new terminal tab and run
    ````
    docker exec -it -u 0 php-tititi bash
    php src/examples/redis/RedisPublishExample.php
    ````