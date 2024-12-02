<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class WithdrawLog extends Model
{
    use HasFactory, Filterable, Notifiable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'uid',
        'withdraw_method_id',
        'user_id',
        'currency',
        'rate',
        'amount',
        'charge',
        'final_amount',
        'after_charge',
        'trx',
        'meta',
        'status',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'meta' => 'json'
    ];


    /**
     * @return BelongsTo
     */
    public function withdrawMethod(): BelongsTo
    {
        return $this->belongsTo(WithdrawMethod::class, 'withdraw_method_id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
