<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentUserReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'level',
        'invest',
        'team_invest',
        'deposit',
        'referral_count',
        'reward',
        'status',
    ];
}
