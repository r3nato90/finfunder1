<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PluginConfiguration extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'short_key',
        'status'
    ];


    /**
     * @var string[]
     */
    protected $casts = [
        'short_key' => 'json'
    ];

}
