<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matrix extends Model
{
    use HasFactory;

    protected $table = 'matrix';
    /**
     * @var array
     */
    protected  $fillable = [
        'uid',
        'name',
        'amount',
        'referral_reward',
        'is_recommend',
        'status'
    ];


    public function matrixLevel(): HasMany
    {
        return $this->hasMany(MatrixLevel::class, 'plan_id');
    }


    public function matrixEnrolled(): HasMany
    {
        return $this->hasMany(MatrixInvestment::class, 'plan_id');
    }




}
