<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'name', 'sendDate', 'dueDate'];

    protected $dates = ['dueDate', 'sendDate', 'deleted_at'];

    public function attributes()
    {
       return $this->hasMany('App\InvoiceAttributes');
    }

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function credited()
    {
      return $this->hasOne('App\CreditedInvoices');
    }

    public function getTotal()
    {
      $subtotal = 0;
      foreach($this->attributes()->get() as $line) {
        $subtotal += $line->quantity * $line->price;
      }
      return $subtotal * .21 + $subtotal;
    }

    public function isCredited()
    {
      if (isset($this->credited)) {
        return true;
      }
      return false;
    }
}
