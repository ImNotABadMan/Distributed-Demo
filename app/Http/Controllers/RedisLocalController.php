<?php

namespace App\Http\Controllers;

use App\Libs\DbConnection;
use Illuminate\Http\Request;
use Illuminate\Redis\Connections\PhpRedisConnection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class RedisLocalController extends Controller
{
    private $killProductID = 6;

    /***
     * @var \Illuminate\Redis\Connections\PhpRedisConnection
     */
    private $redis;

    public function __construct()
    {
        $this->redis = Cache::getRedis()->connection();
    }


    public function index()
    {
        // 获取分布式锁
        // 对应标识 A -- a_fen_bu_shi_lock
        $lock = Cache::lock("fen_bu_shi_lock", 10);
        if ($lock->get()) {
            // 模拟业务执行需要的时间
            // 生成特定请求的锁
            usleep(250 * 1000);
            $lock->release();
        }
    }

    public function normalKill()
    {
        // 可以处理10QPS
        // 方案一
        // 直接不加锁，依赖redis内存快
        // 结果：还是会超卖
        // 127.0.0.1:16379> get stock -----------> "-1"
        // 127.0.0.1:16379> get stock1 --> "-1"
        $stock = $this->redis->get("stock1");
        dump($stock);

        if ($stock > 0) {
            $this->redis->decr("stock1");

            return "Redis 秒杀<b>成功</b>";
        }

        return "Redis 秒杀<b>失败</b>";
    }

    public function leGuanKill()
    {
        /** @var PhpRedisConnection $redis */
        $redis = Cache::getRedis()->connection();

        $stock = 0;
        // 管道，一次请求IO，小优化
        $result = $redis->pipeline(function (\Redis $redis) use (&$stock) {
            // 乐观锁监视
            $redis->watch("le_stock");
            $stock = $redis->get("le_stock");
        });

        dump($result);
        dump($this->redis->get('le_stock'));
        if (!empty($result[1]) && $result[1] > 0) {
            $result = $this->redis->pipeline(function (\Redis $redis) {
                $redis->multi();
                $redis->decr("le_stock");
                $redis->exec();
            });
            dump($result);

            if ($result[0][0] ?? false) {
                DbConnection::connection(2)->table("ss_products_log")->insert([
                    "productID" => $this->killProductID,
                    "desc" => vsprintf("%s, %s", [Session::getId(), "Le Guan Suo Kill."])
                ]);
                return "Redis 秒杀<b>成功</b>";
            } else {
                return "Redis 秒杀<b>失败</b>";
            }
        }

        return "Redis 秒杀<b>失败</b>";
    }
}
