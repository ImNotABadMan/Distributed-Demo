<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transformer\RedisTrans;
use Illuminate\Http\Request;
use Illuminate\Redis\Connections\PhpRedisConnection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class RedisController extends Controller
{
    /***
     * @var PhpRedisConnection
     */
    private $redis;

    public function __construct()
    {
        $this->redis = Cache::getRedis()->connection();
    }

    public function index()
    {
        return view('admin.redis');
    }

    public function all(RedisTrans $redisTrans)
    {
        // lua脚本
        $lua = <<<LUA
local keys = redis.call('keys', '*')

local function all(keys)
    local arr = {}
    local typeStr = ''
    local keyLen = #keys
    local listLen = 0
    local zsetLen = 0

    for index, key in pairs(keys) do
        typeStr = redis.call('type', key)['ok']
        -- 变成数字下标才可以返回成功
        -- 关联字符下标返回不成功，但能用关联下标取得值
        arr[index] = {}
        arr[index][1] = key
        if (typeStr == 'list') then
            listLen = redis.call('llen', key)
            arr[index][2] = redis.call('lrange', key, 0, listLen)
        elseif (typeStr == 'zset') then
            zsetLen = redis.call('zcard', key)
            arr[index][2] = redis.call('zrange', key, 0, zsetLen)
        elseif (typeStr == 'hash') then
            arr[index][2] = redis.call('hgetall', key)
        elseif (typeStr == 'string') then
            arr[index][2] = redis.call('get', key)
        end
    end

    return arr
end

return all(keys)

LUA;
        $luaRes = $this->redis->eval($lua, 0);

        $data = $redisTrans->transKeyValue($luaRes);

        return ["data" => $data];
    }

}

// local keys = redis.call('keys', '*');local keyLen = #keys;local arr = {};local typeStr = '';for index, key in pairs(keys) do typeStr = redis.call('type', key)['ok'];if (typeStr == 'list') then listLen = redis.call('llen', key);arr[key] = redis.call('lrange', key, 0, listLen); elseif (typeStr == 'string') then arr[key] = redis.call('get', key); end end return arr
