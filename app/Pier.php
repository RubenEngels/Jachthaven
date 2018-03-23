<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pier extends Model
{
    protected $guarded = [];

    public function boxes()
    {
      return $this->hasMany('App\Box');
    }
}
