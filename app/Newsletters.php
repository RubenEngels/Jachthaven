<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newsletters extends Model
{
    protected $fillable = ['content', 'name'];

    protected $dates = ['created_at'];
}
