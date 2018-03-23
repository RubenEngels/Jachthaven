<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventRsvp extends Model
{
    protected $guarded = [];

    public function event()
    {
      return $this->belongsTo('App\Events');
    }
}
