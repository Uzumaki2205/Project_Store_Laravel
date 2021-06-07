<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotions extends Model
{
    protected $table = 'promotions';
    public function product() {
        return $this->hasMany(\App\Products::class);
    }
}
