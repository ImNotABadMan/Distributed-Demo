<?php

namespace Tests\Unit;

use App\Libs\DbConnection;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    public function testTestDb()
    {
        $str = (new DbConnection())->test();
        $this->assertEquals("test", $str, "Empty");
    }

    public function testStaticDb()
    {
        $dbObj = $this->getMockBuilder("DbConnection")->getMock();
        $dbObj->method("connection")->withAnyParameters()->willReturn("mysql");
        $this->assertEquals("tests", $dbObj->connection(2), "Empty");
    }

    public function testAnScDb()
    {
        $dbObj = $this->createStub(DbConnection::class);
        $this->assertEquals("tests", $dbObj::connection(2), "Empty");
    }

    public function testStDb()
    {
        $this->assertEquals("mysql", DbConnection::subConnectName(2), "Empty");
    }

    public function testDb()
    {
        $this->assertEquals("mysql", DbConnection::connection(2), "Empty");
    }
}
