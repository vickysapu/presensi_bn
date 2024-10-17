<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class penggunalogin extends Authenticatable
{
    use Notifiable;

    protected $table = 'penggunalogin'; 

    protected $fillable = [
        'keamanan', 
    ];


}
