<?php

namespace App\Http\Controllers;

use App\Libs\DbConnection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class DbController extends Controller
{
    private $killProductID = 6;

    public function index()
    {
        return view('db');
    }

    public function all()
    {
        $res = DbConnection::connection(1)->table('users')
            ->get()->pluck([], 'id');
        $res1 = DbConnection::connection(2)->table('users')
            ->get()->pluck([], 'id');

        $collection = new Collection();
        $collection = $collection->merge($res)->merge($res1)->sortKeys();

        return ['data' => $collection];
    }

    public function one(Request $request)
    {
        $one = DbConnection::connection($request->id)->table('users')
            ->where(['id' => $request->id])
            ->get();

        return ['data' => $one];
    }

    public function dbKill()
    {
        // 对ID 6 进行秒杀
        $product = DbConnection::connection(2)->table('ss_products')
            ->where("productID", $this->killProductID)
            ->first();

        dump(DbConnection::connection(2));


        if ($product->in_stock > 0) {
            // 模拟业务场景
            sleep(2);

            DbConnection::connection(2)->update("update ss_products set in_stock = in_stock - 1, onhold = onhold + 1
                where productID = {$this->killProductID}");

            // 超卖了，但in_stock总是等于0，因为代码编写问题，代码获得stock存放到进程所用的内存，
            // 当两个请求产生两个进程时，获取的stock是相同的，代码做减法，得到的结果是一样的
//            DbConnection::connection(2)->table('ss_products')
//                ->where("productID", $this->killProductID)
//                ->update([
//                    "in_stock" => --$product->in_stock,
//                    "onhold"=> ++$product->onhold,
//                ]);

            DbConnection::connection(2)->table("ss_products_kill_log")->insert([
                'productID' => $this->killProductID,
                'desc' => vsprintf("%s -- killed ", ["get" => Session::getId()])
            ]);

            return "数据库秒杀<h5 class='alert-success alert'>成功</h5>";
        }

        return "数据库秒杀<h5 class='alert-danger alert'>失败</h5>";
    }
}
