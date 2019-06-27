<?php

namespace Fidelize\Tititi;

class PubSubClient 
{    
    public $adapter;

    public function __construct($driver)
    {
        $connection = new PubSubConnectionFactory();
        $this->adapter = $connection->make($driver);
    }

    public function consume($channel) {
        try {    
            $this->adapter->subscribe($channel, function ($message) {
                var_dump($message);
            });

        } catch (\Throwable $th) {
            var_dump($th);
            return 'Erro ao enviar a msg';
        }
    }

    public function publish($channel, $message) {
        try {    
            $this->adapter->publish($channel, $message);
        } catch (\Throwable $th) {
            var_dump($th);
            return 'Erro ao enviar a msg';
        }
    }

}