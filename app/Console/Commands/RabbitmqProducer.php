<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use RdKafka\Conf;
use RdKafka\Producer;

class RabbitmqProducer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:rabbitmq';

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
        $this->testRabbitMQ();

        $this->testKafka();

//        $this->testMySQL();

        return 0;
    }

    private function testKafka()
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', '192.168.10.113:9092');
//        $conf->set('queue.buffering.max.messages', 5000);
//        $conf->set('queued.max.messages.kbytes', 65536 * 1024 * 2);
//        $conf->set('batch.size', 1024 * 1024);
//        $conf->set('batch.num.messages', 50000);
        $conf->set('linger.ms', 1);

        $this->producer = new Producer($conf);

        $this->topic = $this->producer->newTopic('shopify-publish');
//        dd($conf);


        dump("start kafka produce:");

        $now = now();
        dump($now->toDateTimeString('millisecond'));

        for ($i = 0; $i < 10000; $i++) {
            $this->topic->produce(RD_KAFKA_PARTITION_UA, 0, str_repeat('testtesttt', 100));
        }

        $len = $this->producer->getOutQLen();
        while ($len > 0) {
            $len = $this->producer->getOutQLen();
//            var_dump($len);
            $this->producer->poll(50);
        }
        // 及时写入
//        $res = $this->producer->flush(500);
//        dump($res);

        $end = now();
        dump($end->diff($now)->i . ":" . $end->diff($now)->s . ":" . $end->diff($now)->f);
        dump($end->toDateTimeString('millisecond'));

    }

    private function testRabbitMQ()
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare('hello', false, false, false, false);
//        $channel->confirm_select();

        dump("start rabbitmq produce:");

        $now = now();
        dump($now->toDateTimeString('millisecond'));

        $msg = new AMQPMessage(serialize(str_repeat('testtest', 10)));
        for ($i = 0; $i < 10000; $i++) {
            $channel->basic_publish($msg, '', 'hello');
//            $channel->wait_for_pending_acks(5.000);
        }

        $end = now();
        dump($end->diff($now)->i . ":" . $end->diff($now)->s . ":" . $end->diff($now)->f);
        dump($end->toDateTimeString('millisecond'));

        $channel->close();
        $connection->close();



//
//        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
//        $channel = $connection->channel();
//        $channel->queue_declare('hello', false, false, false, false);
//        $callback = function ($msg) {
//            echo ' [x] Received ', $msg->body, "\n";
//        };
//        $channel->basic_consume('hello', '', false, true, false, false, $callback);
//        while ($channel->is_open()) {
//            $channel->wait();
//        }

//        echo " [x] Sent 'Hello World!'\n";
    }

    private function testMySQL()
    {

        dump("start mysql produce:");

        $now = now();
        dump($now->toDateTimeString('millisecond'));

        $payload = str_repeat('testtesttt', 100);

        for ($i = 0; $i < 10000; $i++) {
            DB::insert('insert into test_mysql_queue values(null, ?)', [$payload]);
        }


        $end = now();
        dump($end->diff($now)->i . ":" . $end->diff($now)->s . ":" . $end->diff($now)->f);
        dump($end->toDateTimeString('millisecond'));


    }

}
