<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceProducts extends Model
{
    protected $fillable = ['name', 'price', 'quantity', 'default_on_invoice'];

    protected $dates = ['created_at'];
}
