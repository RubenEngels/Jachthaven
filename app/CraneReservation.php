<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CraneReservation extends Model
{
    protected $guarded = [];

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function boat()
    {
      return $this->belongsTo('App\Boats');
    }
}
