<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticate;

class Contributor extends Authenticate
{
    use HasFactory;


    protected $table = 'ltu_contributors';



}
