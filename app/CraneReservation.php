<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CraneReservation extends Model
{
    protected $fillable = ['date', 'time', 'type', 'user_id', 'boat_id'];

    public function user()
    {
      return $this->belongsTo('App\User');
    }
}
