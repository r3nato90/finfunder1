<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class InvestmentLog extends Model
{
    use HasFactory, Filterable, Notifiable;

    protected $fillable = [
        'uid',
        'user_id',
        'investment_plan_id',
        'plan_name',
        'amount',
        'interest_rate',
        'period',
        'time_table_name',
        'hours',
        'profit_time',
        'last_time',
        'should_pay',
        'profit',
        'trx',
        'recapture_type',
        'is_reinvest',
        'return_duration_count',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(InvestmentPlan::class, 'investment_plan_id');
    }
}
