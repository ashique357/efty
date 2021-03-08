<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    public function transport()
    {
        return $this->belongsTo('App\Transport');
    }
    public function seats()
    {
        return $this->hasMany('App\Seat');
    }
}
