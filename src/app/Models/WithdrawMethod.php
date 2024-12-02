<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawMethod extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'currency_name',
        'min_limit',
        'max_limit',
        'percent_charge',
        'fixed_charge',
        'rate',
        'name',
        'file',
        'parameter',
        'status',
        'instruction'
    ];

    protected $casts = [
        'parameter' => 'json'
    ];

}
