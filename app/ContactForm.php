<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    public $table = 'contact_forms';

    protected $fillable = ['name', 'email', 'message'];
}
