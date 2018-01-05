<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boats extends Model
{

    protected $fillable = [
      'name',
      'user_id',
      'brand',
      'type',
      'color',
      "length",
      "width",
      "depth",
      "heigth",
      "boatType",
      "inHabour",
    ];

    protected $dates = ['created_at'];

    public function User()
    {
      return $this->belongsTo('App\User');
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
