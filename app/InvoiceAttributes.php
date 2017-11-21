<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceAttributes extends Model
{
    protected $fillable = ['invoice_id', 'name', 'price'];

    public function invoice()
    {
      return $this->belongsTo('App\Invoice');
    }
}
