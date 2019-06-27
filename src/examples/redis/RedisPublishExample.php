<?php

include __DIR__ . '/../../../vendor/autoload.php';

$connection = new \Fidelize\Tititi\PubSubConnectionFactory();
$adapter = $connection->make('redis');

$adapter->publish('my_channel', 'HELLO PUB SUB BARATONA');
$adapter->publish('my_channel', ['hello' => 'world']);
$adapter->publish('my_channel', 1);
$adapter->publish('my_channel', false);
