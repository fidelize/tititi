<?php

include __DIR__ . '/../../../vendor/autoload.php';

putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/../../../data/baratona-d15119261d3d.json');

$client = new \Google\Cloud\PubSub\PubSubClient([
    'projectId' => 'baratona',
]);

$adapter = new \Superbalist\PubSub\GoogleCloud\GoogleCloudPubSubAdapter($client);

$adapter->publish('PBM_SANOFI', 'Hello World');
$adapter->publish('PBM_SANOFI', ['lorem' => 'ipsum']);
$adapter->publish('PBM_SANOFI', '{"blah": "bleh"}');
