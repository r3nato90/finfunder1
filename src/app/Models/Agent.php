<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Agent extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'username',
        'email',
        'phone',
        'password',
        'status',
    ];


    public function getFullNameAttribute(): string
    {
        return $this->name;
    }


    /**
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];
}
