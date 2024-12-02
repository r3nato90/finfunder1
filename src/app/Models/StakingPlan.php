<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StakingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'duration',
        'interest_rate',
        'minimum_amount',
        'maximum_amount',
        'status',
    ];
}
