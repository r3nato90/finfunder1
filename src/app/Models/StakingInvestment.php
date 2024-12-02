<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class StakingInvestment extends Model
{
    use HasFactory, Filterable, Notifiable;


    protected $fillable = [
        'user_id',
        'staking_plan_id',
        'amount',
        'interest',
        'expiration_date',
        'status',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
