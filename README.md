# Tititi is a component

## Running in a local environment

- Copy the file below and update it filling with your account data (required if you wanna to use Google Cloud)
    ````
    cp -v data/credentials.example.json data/credentials.json
    ````

- Run the script below to up the system
    ````
    chmod +x setup.sh && ./setup.sh
    ````

### Testing with Redis

- Keep 2 terminal tabs running, both with the PHP container bash console available:
    - Open a new terminal tab and run 
        ````
        docker exec -it -u 0 php-tititi bash
        ````
- Run (inside the first terminal for PHP container)
    ````
    php src/examples/redis/RedisConsumerExample.php
    ````

- Run (inside the second terminal for PHP container)
    ````
    php src/examples/redis/RedisPublishExample.php
    ````

### Testing with Google Cloud

- Keep 2 terminal tabs running, both with the PHP container bash console available:
    - Open a new terminal tab and run 
        ````
        docker exec -it -u 0 php-tititi bash
        ````
- Run (inside the first terminal for PHP container)
    ````
    php src/examples/redis/RedisConsumerExample.php
    ````

- Run (inside the second terminal for PHP container)
    ````
    php src/examples/redis/RedisPublishExample.php
    ````

