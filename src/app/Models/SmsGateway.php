<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsGateway extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'code',
        'name',
        'credential',
        'status'
    ];

    protected $casts = [
        'credential' => 'json'
    ];
}
