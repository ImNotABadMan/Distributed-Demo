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
local keys = redis.call('keys', '*')cd
local keyLen = #keys+
local arr = {}

for key, value in pairs(keys) do
    return redis.call('type', 'le_stock')

end
return arr
LUA;

        //if (typeStr == 3) then
        //        listLen = redis.call('llen', value)
        //        arr[value] = redis.call('lrange', value, 0, listLen)
        //    elseif (type == 1) then
        //        arr[value] = redis.call('get', value)
        //    end
        $luaRes = $this->redis->eval($lua, 0);

        $data = [];

        return ["data" => $luaRes];
    }
}
