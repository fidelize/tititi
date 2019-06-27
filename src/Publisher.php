<?php

namespace Fidelize\Tititi;

class Publisher 
{    
    public function sendMessage($channel, $message) {
        try {
            var_dump('$pubsub');
            $connection = new PubSubConnectionFactory();
            $pubsub = $connection->make('redis');
            
            $pubsub->publish($channel, $message);

        } catch (\Throwable $th) {
            var_dump($th);
            return 'Erro ao enviar a msg';
        }
    }

}