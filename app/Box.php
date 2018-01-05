<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $fillable = [
      'public_id', 'boat_id',
    ];

    public function boat() {
      return $this->hasOne('App\Boats');
    }
}
