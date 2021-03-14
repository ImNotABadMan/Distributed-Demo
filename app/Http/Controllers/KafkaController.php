<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use RdKafka\Conf;
use RdKafka\Consumer;
use RdKafka\Producer;

class KafkaController extends Controller
{
    public function index()
    {
        $conf = new Conf();
        $conf->set('log_level', (string) LOG_DEBUG);
        $conf->set('debug', 'all');
        $kafkaConsumer = new Consumer($conf);
        $kafkaConsumer->addBrokers(config('kafka.host'));

        $topic = $kafkaConsumer->newTopic("my-replicated-topic");
        $topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);

        $msg = $topic->consume(0, 1000);
        dump($msg);
    }

    public function producer()
    {
        $user = User::first();
        $conf = new Conf();
        $conf->set('log_level', (string) LOG_DEBUG);
        $conf->set('debug', 'all');
        $kafkaProducer = new Producer($conf);
        $kafkaProducer->addBrokers(config('kafka.host'));
        $topic = $kafkaProducer->newTopic("my-replicated-topic");

        for ($i = 0; $i < 100000; $i++) {

            $topic->produce(0, 0, $user);
        }
        dump($kafkaProducer);
        dump($topic);


    }
}
