<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotions extends Model
{
    protected $table = 'promotions';
    public $timestamps = false;

    public function product()
    {
        return $this->hasMany(\App\Products::class);
    }
}
