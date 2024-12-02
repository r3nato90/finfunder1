<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradeLog extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'user_id',
        'crypto_currency_id',
        'original_price',
        'amount',
        'duration',
        'arrival_time',
        'type',
        'volume',
        'outcome',
        'status',
        'meta',
    ];

    protected $casts = [
        'meta' => 'json',
        'arrival_time' => 'datetime:Y-m-d H:i:s',
    ];

    public function cryptoCurrency(): BelongsTo
    {
        return $this->belongsTo(CryptoCurrency::class, 'crypto_currency_id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
