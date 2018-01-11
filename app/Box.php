<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $fillable = [
      'public_id', 'boat_id', 'isWalplaats', 'pier_id'
    ];

    public function boat()
    {
      return $this->hasOne('App\Boats');
    }

    public function rent()
    {
      return $this->hasOne('App\RentedBox');
    }

    public function pier()
    {
      return $this->belongsTo('App\Pier');
    }
}
