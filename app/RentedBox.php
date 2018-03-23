<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentedBox extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $dates = ['created_at'];

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function box()
    {
      return $this->belongsTo('App\Box');
    }
}
