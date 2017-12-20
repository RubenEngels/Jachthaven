<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
  protected $fillable = ['name', 'location', 'date', 'from', 'till'];

  protected $dates = ['date'];

  public function rsvp()
  {
    return $this->hasMany('App\EventRsvp', 'event_id');
  }
}
