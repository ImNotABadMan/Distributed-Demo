<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use RdKafka\Conf;
use RdKafka\Consumer;

class KafkaConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:consumer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $conf = new Conf();
        $conf->set('log_level', (string) LOG_DEBUG);
//        $conf->set('debug', 'all');
        dump($conf);
        $kafkaConsumer = new Consumer($conf);
        $kafkaConsumer->addBrokers(config('kafka.host'));
        dump($kafkaConsumer);
        $topic = $kafkaConsumer->newTopic("my-replicated-topic");
        $topic->consumeStart(0, RD_KAFKA_OFFSET_END);

        while (true) {
            try {
                $msg = $topic->consume(0, 1000);
                dump($msg);
                if (!is_null($msg) && !empty($msg->payload)) {
                    $user = json_decode($msg->payload, true);
                    $userEloquent = User::find($user['id']);
                    dump($userEloquent);
                }
                unset($msg);
                unset($user);
                unset($userEloquent);
                gc_mem_caches();
                gc_collect_cycles();
            } catch (\Exception $exception) {
                dump($exception);
                break;
            }


        }

        return 0;
    }
}
