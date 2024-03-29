<?php


namespace Kerogos\LaravelDynomite\Connections;


use Illuminate\Redis\Connections\PhpRedisConnection;

class PhpDynomiteConnection extends PhpRedisConnection
{
    public function flushdb()
    {
        $keys = $this->keys('*');
        return $this->del($keys);
    }
    public function command($method, array $parameters = [])
    {
        if(config('dynomite.debug'))
            \Log::debug('DynomiteConnectionCommand',['command' => $method, 'params' => $parameters]);
        return parent::command($method, $parameters);
    }

    public function blpop(...$arguments)
    {
        if(config('dynomite.debug'))
            \Log::debug('DynomiteConnectionCommandBlPop',['params' => $arguments ?? false]);
        return parent::blpop($arguments); // TODO: Change the autogenerated stub
    }
}
