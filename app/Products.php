<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';

    public function category()
    {
        return $this->belongsTo(\App\Categories::class, 'id_category', 'id');
    }

    public function promotion()
    {
        return $this->belongsTo(\App\Promotions::class, 'id_promotion', 'id');
    }

    public function image()
    {
        return $this->hasMany(\App\Images::class);
    }

    public function cart()
    {
        return $this->hasMany(\App\Carts::class);
    }

    public function inventory()
    {
        return $this->hasMany(\App\Inventories::class);
    }
}
