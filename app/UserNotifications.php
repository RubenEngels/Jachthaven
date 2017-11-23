<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotifications extends Model
{
    protected $fillable = ['show', 'type', 'message'];
}
