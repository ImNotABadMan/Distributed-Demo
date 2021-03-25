<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RdKafka\Conf;
use RdKafka\Message;
use RdKafka\Producer;

class KafkaProducer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:producer';

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
//        $user = User::first();
//        $user = "test " . date('Y-m-d H:i:s');
        $conf = new Conf();
        $conf->set('log_level', (string)LOG_DEBUG);
//        $conf->set('bootstrap.servers', config('kafka.host'));
        $conf->set('enable.idempotence', "true");
//        // once
//        pcntl_sigprocmask(SIG_BLOCK, array(SIGIO));
//        // any time
//        $conf->set('internal.termination.signal', SIGIO);
//        $conf->set('message.send.max.retries', 2);
        // 在构造要发送给代理的消息批（MessageSet）之前等待生产者队列中的消息累积的毫秒数。
        // 较高的值允许以更大的消息传递等待时间为代价来积累更大，更有效（开销更少，压缩效果更佳）的消息批次。
        $conf->set('queue.buffering.max.ms', 1);

//        $conf->set('batch.size', 1024 * 1000);
//        $conf->set('debug', 'all');
//        $conf->set('api.version.request', true);


        $conf->setStatsCb(function ($kafka, $json, $json_len){
            dump("setStatsCb");
            dump($json);
            dump($json_len);
//            dump($kafka);
        });

        $conf->setErrorCb(function ($kafka, $err, $reason){
            dump("setErrorCb");
            dump($err);
            dump($reason);
//            dump($kafka);
        });

        $conf->setDrMsgCb(function ($kafka, Message $message) {
            dump("setDrMsgCb");
            dump("message key: " . $message->key);
//            dump($kafka);
        });
        $kafkaProducer = new Producer($conf);
        $kafkaProducer->addBrokers(config('kafka.host'));
        $topic = $kafkaProducer->newTopic("my-replicated-topic");

//        $kafkaProducer->addBrokers("192.168.10.108");
//        $topic = $kafkaProducer->newTopic("test1");

//        dump($kafkaProducer);

//        while (true) {
        $user = "test " . date('Y-m-d H:i:s');
        dump($kafkaProducer->getOutQLen());
        $index = 0;

        for($i = 0; $i < 5; $i++) {
//            $kafkaProducer->beginTransaction();
            $topic->produce(0, 0, $user, $user);
//        dump($kafkaProducer->getOutQLen());
            dump("getOutQLen " . $kafkaProducer->getOutQLen());
            $res = $kafkaProducer->flush(2);
            if ($res < 0) {
                $index++;
            }
            dump("flush {$res} getOutQLen " . $kafkaProducer->getOutQLen());
//
//            if ($res != 0) {
//                $topic->produce(0, 0, $user, $user);
//                $res = $kafkaProducer->flush(5);
//                dump("retry flush {$res} getOutQLen " . $kafkaProducer->getOutQLen());
//            }

//            $kafkaProducer->commitTransaction(1);

//            while ($kafkaProducer->getOutQLen() > 0) {
//                $kafkaProducer->poll(10);
//                dump(++$index);
//            }
//            dump("flush " . $res);
        }
        dump("count : " . $index);

//        exit();
//        dump($kafkaProducer->getOutQLen());



//            dump($user);
//        }
//        dump($kafkaProducer);
//        dump($topic);
        return 0;
    }
}
