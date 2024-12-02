<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'time', 'unit', 'status'
    ];
}
