<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boats extends Model
{
    public function User()
    {
      return $this->belongsTo('App\User');
    }
}
