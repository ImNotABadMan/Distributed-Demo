<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function all()
    {
        // lua脚本
        $lua = <<<LUA
local keys = redis.call('keys', '*')

local function all(keys)
    local arr = {}
    local typeStr = ''
    local keyLen = #keys

    for index, key in pairs(keys) do
        typeStr = redis.call('type', key)['ok']
        arr[index][1] = key
        if (typeStr == 'list') then
            listLen = redis.call('llen', key)
            arr[index][2] = redis.call('lrange', key, 0, listLen)
        elseif (typeStr == 'string') then
            arr[index][2] = redis.call('get', key)
        end
    end

    return arr
end

return all(keys)

LUA;

        //return arr

        $luaRes = $this->redis->eval($lua, 0);

        $data = [];

        return ["data" => $luaRes];
    }
}

// local keys = redis.call('keys', '*');local keyLen = #keys;local arr = {};local typeStr = '';for index, key in pairs(keys) do typeStr = redis.call('type', key)['ok'];if (typeStr == 'list') then listLen = redis.call('llen', key);arr[key] = redis.call('lrange', key, 0, listLen); elseif (typeStr == 'string') then arr[key] = redis.call('get', key); end end return arr
