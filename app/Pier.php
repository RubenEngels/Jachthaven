<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pier extends Model
{
    protected $fillable = ['public_id'];

    public function boxes()
    {
      return $this->hasMany('App\Box');
    }
}
