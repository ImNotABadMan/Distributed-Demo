<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RdKafka\Conf;
use RdKafka\Consumer;

class KafkaController extends Controller
{
    public function index()
    {
        $conf = new Conf();
        $conf->set('log_level', (string) LOG_DEBUG);
        $conf->set('debug', 'all');
        $kafkaConsumer = new Consumer($conf);
        $kafkaConsumer->addBrokers("192.168.10.113");

        $topic = $kafkaConsumer->newTopic("my-replicated-topic");
        $topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);

        $msg = $topic->consume(0, 1000);
        dump($msg);
    }
}
