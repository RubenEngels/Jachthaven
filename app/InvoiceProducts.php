<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceProducts extends Model
{
    protected $fillable = ['name', 'price', 'quantity'];

    protected $dates = ['created_at'];
}
