<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventRsvp extends Model
{
    protected $fillable = ['event_id', 'name', 'email'];
    
    public function event()
    {
      return $this->belongsTo('App\Events');
    }
}
