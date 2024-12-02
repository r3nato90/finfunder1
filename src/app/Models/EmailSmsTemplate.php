<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSmsTemplate extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected  $fillable = [
        'code',
        'name',
        'subject',
        'from_email',
        'mail_template',
        'sms_template',
        'short_key',
        'status'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'short_key' => 'json'
    ];
}
