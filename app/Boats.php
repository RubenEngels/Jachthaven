<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boats extends Model
{
    protected $guarded = [];

    protected $dates = ['created_at'];

    public function User()
    {
      return $this->belongsTo('App\User');
    }

    public function inBox() {
      return $this->inHabour;
    }

    public function Reservations()
    {
      return $this->hasMany('App\CraneReservation', 'boat_id');
    }

    public function Box()
    {
      return $this->belongsTo('App\Box');
    }
}
