<?php

namespace Fidelize\Tititi;

use InvalidArgumentException;
use Predis\Client;
use Superbalist\PubSub\Adapters\DevNullPubSubAdapter;
use Superbalist\PubSub\Adapters\LocalPubSubAdapter;
use Superbalist\PubSub\GoogleCloud\GoogleCloudPubSubAdapter;
use Superbalist\PubSub\PubSubAdapterInterface;
use Superbalist\PubSub\Redis\RedisPubSubAdapter;

class PubSubConnectionFactory
{
    /**
     * Factory a PubSubAdapterInterface.
     *
     * @param string $driver
     * @param array $config
     *
     * @return PubSubAdapterInterface
     */
    public function make($driver, array $config = [])
    {
        switch ($driver) {
            case '/dev/null':
                return new DevNullPubSubAdapter();
            case 'local':
                return new LocalPubSubAdapter();
            case 'redis':
                return $this->makeRedisAdapter($config);
            case 'gcloud':
                return $this->makeGoogleCloudAdapter($config);
        }

        throw new InvalidArgumentException(sprintf('The driver [%s] is not supported.', $driver));
    }

    /**
     * Factory a RedisPubSubAdapter.
     *
     * @param array $config
     *
     * @return RedisPubSubAdapter
     */
    protected function makeRedisAdapter(array $config)
    {
        if (!isset($config['read_write_timeout'])) {
            $config['read_write_timeout'] = 0;
        }

        $client = new Client([
            'scheme' => 'tcp',
            'host' => 'redis',
            'port' => 6379,
            'database' => 0,
            'read_write_timeout' => 0
        ]);

        return new RedisPubSubAdapter($client);
    }

    /**
     * Factory a GoogleCloudPubSubAdapter.
     *
     * @param array $config
     *
     * @return GoogleCloudPubSubAdapter
     */
    protected function makeGoogleCloudAdapter(array $config)
    {
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/../data/baratona-d15119261d3d.json');

        $client = new \Google\Cloud\PubSub\PubSubClient([
            'projectId' => 'baratona',
        ]);

        return new \Superbalist\PubSub\GoogleCloud\GoogleCloudPubSubAdapter($client);
    }
}
