<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgentTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'amount',
        'post_balance',
        'charge',
        'trx',
        'details',
        'type',
    ];


    /**
     * @return BelongsTo
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }
}
