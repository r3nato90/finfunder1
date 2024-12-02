<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvestmentPlan extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'uid',
        'name',
        'minimum',
        'maximum',
        'interest_rate',
        'duration',
        'meta',
        'terms_policy',
        'is_recommend',
        'type',
        'amount',
        'status',
        'interest_type',
        'time_id',
        'interest_return_type',
        'recapture_type',
    ];

    protected $casts = [
        'meta' => 'json'
    ];


    public function investmentLogs(): HasMany
    {
        return $this->hasMany(InvestmentLog::class, 'investment_plan_id');
    }


    public function timeTable(): BelongsTo
    {
        return $this->belongsTo(TimeTable::class, 'time_id');
    }
}
