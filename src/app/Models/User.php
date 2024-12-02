<?php

namespace App\Models;

use App\Enums\Payment\Deposit\Status;
use EloquentFilter\Filterable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticate implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Filterable, TwoFactorAuthenticatable;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'username',
        'email',
        'phone',
        'image',
        'email_verified_at',
        'kyc_status',
        'status',
        'password',
        'referral_by',
        'position_id',
        'position',
        'remember_token',
        'google_id',
        'facebook_id',
        'meta',
        'aggregate_investment',
        'collective_investment',
        'last_reward_update',
        'reward_identifier',
        'agent_id',
    ];

    /**
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'meta',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'meta' => 'json'
    ];


    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return BelongsTo
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * @return HasOne
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'user_id');
    }


    public function referredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referral_by');
    }

    public function referredUsers(): HasMany
    {
        return $this->hasMany(User::class, 'referral_by');
    }

    public function positionedAbove(): BelongsTo
    {
        return $this->belongsTo(User::class, 'position_id');
    }


    public function recursiveReferrals(): HasMany
    {
        return $this->referredUsers()->with('recursiveReferrals');
    }


    public function matrixInvestment(): HasOne
    {
        return $this->hasOne(MatrixInvestment::class, 'user_id');
    }

    public function ongoingReferrals()
    {
        return $this->hasMany(User::class, 'referral_by')->whereHas('investments');
    }

    public function investments(): HasMany
    {
        return $this->hasMany(InvestmentLog::class)->orderBy('id', 'desc');
    }

    public function deposit(): HasMany
    {
        return $this->hasMany(Deposit::class)->where('status', Status::SUCCESS->value);
    }
}
