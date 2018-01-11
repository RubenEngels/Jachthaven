<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentedBox extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'box_id'];

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
