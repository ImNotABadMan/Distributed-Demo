<?php


namespace App\Cache\Keys;


class KillCacheKeys
{
    public static function leStock()
    {
        return "le_stock";
    }

    public static function killProductList($productID)
    {
        return "redis_kill_product_" . $productID;
    }

    public static function stock1()
    {
        return "stock1";
    }

    public static function fenBuShiStock()
    {
        return "fen_bu_shi_lock";
    }
}
