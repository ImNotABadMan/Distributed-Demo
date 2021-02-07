<?php

namespace App\Console\Commands;

use App\ProtoBuf\Hello\Hello;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class ProtobufUnpack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:unpack';

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
        $body = Http::get(\route('proto'));
        dump(\route('proto'));
        dump($body->body());

        $hello = new Hello();
        $hello->mergeFromString($body->body());
        dump($hello->getName());
        dump($hello->getText());

        return 0;
    }
}
