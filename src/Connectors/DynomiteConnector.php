<?php
namespace Kerogos\LaravelDynomite\Connectors;


use Illuminate\Redis\Connectors\PhpRedisConnector;
use Illuminate\Support\Arr;
use Kerogos\LaravelDynomite\Connections\PhpDynomiteConnection;

class DynomiteConnector extends PhpRedisConnector
{
    public function connect(array $config, array $options)
    {
        $connector = function () use ($config, $options) {
            return $this->createClient(array_merge(
                $config, $options, Arr::pull($config, 'options', [])
            ));
        };

        return new PhpDynomiteConnection($connector(), $connector, $config);
    }
}
