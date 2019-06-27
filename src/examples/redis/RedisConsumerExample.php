<?php

include __DIR__ . '/../../../vendor/autoload.php';

$connection = new \Fidelize\Tititi\PubSubConnectionFactory();
$adapter = $connection->make('redis');

$adapter->subscribe('my_channel', function ($message) {
    var_dump($message);
});
