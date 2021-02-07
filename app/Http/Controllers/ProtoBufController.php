<?php

namespace App\Http\Controllers;

use App\ProtoBuf\Hello\Hello;
use App\ProtoBuf\Hello\PeopleClient;
use Grpc\ChannelCredentials;
use Illuminate\Http\Request;

class ProtoBufController extends Controller
{
    public function proto()
    {
        $hello = new Hello();
//        $hello->setDes("This is Des");
        $hello->setName("server name");
        $hello->setText("This is Text");
        $jsonStr = $hello->serializeToJsonString();
        $str = $hello->serializeToString();
//        dump($str);
//        dump($jsonStr);

        return $str;
    }

    public function json()
    {
        return [
            'Name' => 'server name',
            'Text' => 'This is Text',
            'Des' => 'This is Des',
        ];
    }

    public function grpc()
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
            dump($c[0]->getText());
            dump($c[0]->getName());
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

    }
}
