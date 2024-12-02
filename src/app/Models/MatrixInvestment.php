<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class MatrixInvestment extends Model
{
    use HasFactory, Filterable, Notifiable;

    protected $fillable = [
        'uid',
        'plan_id',
        'user_id',
        'name',
        'trx',
        'price',
        'referral_reward',
        'referral_commissions',
        'level_commissions',
        'total_profit',
        'meta',
        'status'
    ];

    protected $casts = [
        'meta' => 'json'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
