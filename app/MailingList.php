<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailingList extends Model
{
    public $table = 'mailing_lists';

    protected $guarded = [];

    protected $dates = ['created_at'];
}
