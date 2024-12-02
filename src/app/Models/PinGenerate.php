<?php

namespace App\Models;

use App\Enums\Matrix\PinStatus;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PinGenerate extends Model
{
    use HasFactory, Filterable;

    /**
     * @var array
     */
    protected  $fillable = [
        'uid',
        'user_id',
        'set_user_id',
        'amount',
        'pin_number',
        'details',
        'status',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function setUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'set_user_id');
    }


    /**
     * @param $query
     * @return void
     */
    public function scopeUtilized($query): void
    {
        $query->where('status',PinStatus::USED->value);
    }

    /**
     * @param $query
     * @return void
     */
    public function scopeUnused($query): void
    {
        $query->where('status', PinStatus::UNUSED->value);
    }


    /**
     * @param $query
     * @return void
     */
    public function scopeUsers($query): void
    {
        $query->whereNotNull('set_user_id');
    }


    /**
     * @param $query
     * @return void
     */
    public function scopeAdmins($query): void
    {
        $query->whereNull('set_user_id');
    }

}
