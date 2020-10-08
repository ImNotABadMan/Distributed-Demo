<?php

namespace App\Console\Commands;

use App\Libs\DbConnection;
use Illuminate\Console\Command;
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
        // 延时队列，循环读取
        $this->redis = Cache::getRedis()->connection();

        DbConnection::connection(2)->table("ss_products_kill_log")->insert([
            "productID" => $this->killProductID,
            "desc" => vsprintf("%s, %s", [Session::getId(), "Le Guan Suo Kill."])
        ]);
    }
}
