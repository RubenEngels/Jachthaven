<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newsletters extends Model
{
    protected $guarded = [];
    
    protected $dates = ['created_at'];
}
