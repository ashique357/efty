<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    public function buses()
    {
        return $this->hasMany('App\Bus');
    }

    public function User()
    {
        return $this->belongsTo('App\User');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($transport) { // before delete() method call this
             $transport->buses()->delete();
             // do the rest of the cleanup...
        });
    }

}
