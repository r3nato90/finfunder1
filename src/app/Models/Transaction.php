<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory, Filterable;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'amount',
        'post_balance',
        'charge',
        'trx',
        'details',
        'type',
        'wallet_type',
        'source',
    ];


    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
