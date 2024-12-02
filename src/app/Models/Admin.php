<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    /**
     * @var array
     */
    protected  $fillable = [
        'name',
        'username',
        'email',
        'image',
        'password'
    ];
}
