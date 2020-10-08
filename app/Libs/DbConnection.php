<?php

namespace App\Libs;

use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;

class DbConnection
{
    private static $instance;

    private static $connection;

    /***
     * @param int $id
     * @return string
     */
    public static function subConnectName(int $id)
    {
        return  $id % 2 == 0 ? "mysql" : "mysql1";
    }

    /***
     * @param int $id 奇偶数对应奇偶数据库名称
     * @return \Illuminate\Database\Connection
     */
    public static function connection($id)
    {
        // 分库，取模奇偶数分法

        return DB::connection(self::subConnectName($id));
    }

    public function test()
    {
        return "test";
    }
}
