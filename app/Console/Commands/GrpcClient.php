<?php

namespace App\Console\Commands;

use App\ProtoBuf\Hello\Hello;
use App\ProtoBuf\Hello\PeopleClient;
use Grpc\ChannelCredentials;
use Illuminate\Console\Command;

class GrpcClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grpc:client';

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
        $client = new PeopleClient("192.168.10.113:9998", [
            'credentials' => ChannelCredentials::createInsecure()
        ]);


        $hello = new Hello();
        $hello->setName("from client");
        $hello->setText("from Text");

        $c = $client->SayHello($hello)->wait();
        dump($client);

        if ($c[0] instanceof Hello) {
            dump($c[0]->getName());
            dump($c[0]->getText());
        } else {
            dump($c);
        }

        $c = $client->SayHelloAgain($hello)->wait();
        dump($client);

        if ($c[0] instanceof Hello) {
            dump($c[0]->getText());
            dump($c[0]->getName());
        }

        dump($c);
        return 0;
    }
}
