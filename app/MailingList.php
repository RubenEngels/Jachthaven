<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailingList extends Model
{
    public $table = 'mailing_lists';

    protected $fillable = ['email'];

    protected $dates = ['created_at'];
}
