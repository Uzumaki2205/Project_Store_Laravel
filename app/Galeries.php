<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Galeries extends Model
{
    protected $table = 'galeries';
    public function image() {
        return $this->hasMany(\App\Images::class);
    }
}
