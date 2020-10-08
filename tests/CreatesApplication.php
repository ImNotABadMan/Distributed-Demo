<?php

namespace Tests;

use App\Libs\DbConnection;
use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $app->instance(DbConnection::class, \Mockery::mock(DbConnection::class, function ($mock) {
            $mock->shouldReceive('connection');
        }));

        return $app;
    }
}
