<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $table = 'images';

    public function product()
    {
        return $this->belongsTo(\App\Products::class, 'id_product', 'id');
    }

    public function galery()
    {
        return $this->belongsTo(\App\Galeries::class, 'id_galery', 'id');
    }
}
