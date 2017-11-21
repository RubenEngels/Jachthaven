<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditedInvoices extends Model
{
    protected $fillable = ['invoice_id', 'reason', 'amount'];

    public function invoice()
    {
      return $this->blongsTo('App\Invoice');
    }
}
