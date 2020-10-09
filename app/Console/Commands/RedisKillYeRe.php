<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Redis\Connections\PhpRedisConnection;
use Illuminate\Support\Facades\Cache;

class RedisKillYeRe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:kill-ye-re';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'redis数据初始化';

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
        /** @var PhpRedisConnection $redis */
        $redis = Cache::getRedis()->connection();

        $redis->set("le_stock", 20);
        $redis->set("stock1", 20);

        $this->info("Redis Init le_stock, stock1");
    }
}
