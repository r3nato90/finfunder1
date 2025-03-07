<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrixLevel extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected  $fillable = [
        'plan_id',
        'level',
        'amount'
    ];
}
