<?php

namespace Fidelize\Tititi;

use InvalidArgumentException;
use Predis\Client;
use Superbalist\PubSub\Adapters\DevNullPubSubAdapter;
use Superbalist\PubSub\Adapters\LocalPubSubAdapter;
use Superbalist\PubSub\GoogleCloud\GoogleCloudPubSubAdapter;
use Superbalist\PubSub\HTTP\HTTPPubSubAdapter;
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
            case 'http':
                return $this->makeHTTPAdapter($config);
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
        $clientConfig = [
            'projectId' => $config['project_id'],
            'keyFilePath' => $config['key_file'],
        ];
        if (isset($config['auth_cache'])) {
            $clientConfig['authCache'] = $this->container->make($config['auth_cache']);
        }

        $client = $this->container->makeWith('pubsub.gcloud.pub_sub_client', ['config' => $clientConfig]);

        $clientIdentifier = array_get($config, 'client_identifier');
        $autoCreateTopics = array_get($config, 'auto_create_topics', true);
        $autoCreateSubscriptions = array_get($config, 'auto_create_subscriptions', true);
        $backgroundBatching = array_get($config, 'background_batching', false);
        $backgroundDaemon = array_get($config, 'background_daemon', false);

        if ($backgroundDaemon) {
            putenv('IS_BATCH_DAEMON_RUNNING=true');
        }
        return new GoogleCloudPubSubAdapter(
            $client,
            $clientIdentifier,
            $autoCreateTopics,
            $autoCreateSubscriptions,
            $backgroundBatching
        );
    }

    /**
     * Factory a HTTPPubSubAdapter.
     *
     * @param array $config
     *
     * @return HTTPPubSubAdapter
     */
    protected function makeHTTPAdapter(array $config)
    {
        $client = $this->container->make('pubsub.http.client');
        $adapter = $this->make(
            $config['subscribe_connection_config']['driver'],
            $config['subscribe_connection_config']
        );
        return new HTTPPubSubAdapter($client, $config['uri'], $adapter);
    }
}
