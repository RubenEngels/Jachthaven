<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->admin; // this looks for an admin column in your users table
    }

    public function isOwner()
    {
      return $this->owner; // this looks for an owner column in your users table
    }

    public function invoice()
    {
      return $this->hasMany('App\Invoice');
    }

    public function reservations()
    {
      return $this->hasMany('App\CraneReservation');
    }

    public function boats()
    {
      return $this->hasMany('App\Boats');
    }
}
