<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
class RedisService
{

    /**
     * @param int $id
     * @param File $file
     * @return void
     * @throws \RedisException
     */
    public function create(int $id,File $file):void {

        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6380);
        $keyRedis = 'file-'.$id;
        $redis->set($keyRedis,serialize($file));
        $redis->expireat($keyRedis,time() + 600);
        $redis->expire($keyRedis, 600);
    }


    /**
     * @param int $id
     * @return File|null
     * @throws \RedisException
     */
    public function get(int $id):File | null {
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6380);
        $keyRedis = 'file-'.$id;
        $queryRedis = $redis->get($keyRedis);
        if ($queryRedis) {//елси пустое значение делаем время ожидания
            return unserialize($queryRedis);

        }
        return null;
    }


}