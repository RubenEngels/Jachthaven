<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'name', 'sendDate', 'dueDate'];

    protected $dates = ['dueDate', 'sendDate', 'deleted_at', 'payed_at'];

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
      return round($this->getSubTotal() + $this->getBtw(), 2);
    }

    public function getSubTotal()
    {
      $subtotal = 0;
      foreach ($this->attributes()->get() as $line) {
        $subtotal += $line->quantity * $line->price;
      }
      return round($subtotal, 2);
    }

    public function getBtw()
    {
      return round($this->getSubTotal() / 100 * 21, 2);
    }

    public function isCredited()
    {
      if (isset($this->credited)) {
        return true;
      }
      return false;
    }

    public static function totalOfAll()
    {
      $total = 0;
      foreach (self::all() as $invoice) {
        $total += $invoice->getTotal();
      }
      return $total;
    }
}
