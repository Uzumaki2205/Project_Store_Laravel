<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderCancels extends Model
{
    protected $table = 'order_cancels';
    // public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(\App\Orders::class, 'id_order');
    }
}
