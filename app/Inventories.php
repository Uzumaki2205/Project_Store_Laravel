<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventories extends Model
{
    protected $table = 'inventories';
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(\App\Products::class, 'id_product', 'id');
    }
}
