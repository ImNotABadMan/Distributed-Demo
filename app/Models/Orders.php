<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = "ss_orders";

    protected $primaryKey  = "OrderID";

    public $timestamps = false;
}
