<?php

namespace App\Console\Commands;

use App\Cache\Keys\KillCacheKeys;
use App\Libs\DbConnection;
use Illuminate\Console\Command;
use Illuminate\Contracts\Redis\LimiterTimeoutException;
use Illuminate\Redis\Connections\PhpRedisConnection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class RedisListPop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:list-pop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '延时队列';

    /***
     * @var PhpRedisConnection
     */
    private $redis;

    private $killProductID = 6;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Start Redis List Listen:");
        // 延时队列，循环读取
        $this->redis = Cache::getRedis()->connection();

        while (true) {
            try {
                // 没有数据的时候阻塞读取，不会造成CPU 100%
                $pop = $this->redis->blpop(KillCacheKeys::killProductList($this->killProductID), 0);
                dump("pop", $pop);

                $result = DbConnection::connection(2)->table("ss_products_kill_log")->insert([
                    "productID" => $this->killProductID,
                    "desc" => vsprintf("%s, %s", [$pop[1], "Le Guan Suo Kill."])
                ]);

                if ($result) {
                    // 标准输出流缓存
                    $this->info("{$pop[1]} Get Product Success");
                } else {
                    $this->warn("{$pop[1]} Get Product Failed", "vvv");
                }

                // 缓存刷新并输出到output
                // vvv 是什么
                flush();
            } catch (\RedisException $exception) {
                $this->redis = Cache::getRedis()->connection();
            }
        }

        $this->info("Exit List Pop");
    }
}
