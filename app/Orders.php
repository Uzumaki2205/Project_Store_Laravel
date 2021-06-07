<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';

    public function user()
    {
        return $this->hasMany(\App\User::class, 'id_user');
    }

    public function order_cancel()
    {
        return $this->hasMany(\App\OrderCancels::class);
    }
}
