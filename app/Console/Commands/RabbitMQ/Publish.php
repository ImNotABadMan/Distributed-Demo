<?php

namespace App\Console\Commands\RabbitMQ;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Publish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:publish';

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
        $connection = new AMQPStreamConnection('172.17.0.3',5672,'guest','guest');
        $channel = $connection->channel();

        $channel->queue_declare('hello', false, false, false, false);

        $msg = new AMQPMessage('Hello World!' . date(''));
        $channel->basic_publish($msg, '', 'hello');

        echo " [x] Sent 'Hello World!'\n";

        $channel->close();
        $connection->close();

        return 0;
    }
}
