<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class employee extends Authenticatable
{
	protected $table = 'employee';

	protected $primaryKey = 'UserID';
    protected $fillable = [
        'UserID', 'password', 'FullName', 'Address', 'EmailID', 'Job Title', 'Salary'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
