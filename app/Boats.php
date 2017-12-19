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
    ];

    protected $dates = ['created_at'];

    public function User()
    {
      return $this->belongsTo('App\User');
    }
}
