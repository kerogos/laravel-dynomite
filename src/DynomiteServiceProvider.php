<?php

namespace Kerogos\LaravelDynomite;

use Illuminate\Redis\RedisManager;
use Illuminate\Redis\RedisServiceProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\ServiceProvider;
use Kerogos\LaravelDynomite\Connections\PhpDynomiteConnection;
use Kerogos\LaravelDynomite\Connectors\DynomiteConnector;
use function PHPUnit\Framework\never;

class DynomiteServiceProvider extends RedisServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('redis', function ($app) {
            $config = $app->make('config')->get('database.redis', []);
            $redisManager = new RedisManager($app, Arr::pull($config, 'client', 'dynomite'), $config);
            $redisManager->extend('dynomite',function (){
                return new DynomiteConnector;
            });
            return $redisManager;
        });

        $this->app->bind('redis.connection', function ($app) {
            return $app['redis']->connection();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/dynomite.php' => config_path('dynomite.php')
        ]);
    }
}
