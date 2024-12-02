<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CryptoCurrency extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'name',
        'crypto_id',
        'pair',
        'file',
        'symbol',
        'status',
        'top_gainer',
        'top_loser',
        'meta',
    ];

    protected $casts = [
        'meta' => 'json',
    ];


    public function trade(): HasMany
    {
        return $this->hasMany(TradeLog::class, 'crypto_currency_id');
    }

}
