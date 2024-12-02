<?php

namespace App\Models;

use App\Enums\Payment\GatewayType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';

    protected $fillable = [
        'currency',
        'percent_charge',
        'rate',
        'name',
        'minimum',
        'maximum',
        'code',
        'file',
        'parameter',
        'type',
        'details',
        'status',
    ];

    protected $casts = [
        'parameter' => 'json'
    ];

}
