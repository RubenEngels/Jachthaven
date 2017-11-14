<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    protected $fillable = ['name', 'link', 'public'];

    protected $dates = ['created_at'];
}
