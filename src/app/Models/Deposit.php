<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Deposit extends Model
{
    use HasFactory, Filterable, Notifiable;

    protected $fillable = [
        'user_id',
        'payment_gateway_id',
        'rate',
        'amount',
        'charge',
        'final_amount',
        'trx',
        'crypto_meta',
        'wallet_type',
        'is_crypto_payment',
        'meta',
        'status',
    ];

    protected $casts = [
        'crypto_meta' => 'json',
        'meta'  => 'json',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function gateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class, 'payment_gateway_id');
    }
}
