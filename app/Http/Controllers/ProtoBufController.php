<?php

namespace App\Http\Controllers;

use App\ProtoBuf\Hello\Hello;
use Illuminate\Http\Request;

class ProtoBufController extends Controller
{
    public function proto()
    {
        $hello = new Hello();
        $hello->setDes("This is Des");
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
}
