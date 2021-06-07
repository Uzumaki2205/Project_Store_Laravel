<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    protected $table = 'carts';

    public function user() {
        return $this->belongsTo(\App\User::class, 'id_user');
    }

    public function product() {
        return $this->belongsTo(\App\Products::class, 'id_product');
    }
}
