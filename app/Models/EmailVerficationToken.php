<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerficationToken extends Model
{
    protected $fillable = [
        'email',
        'token',
        'expires_at',
    ];

    protected $table = 'email_verification_tokens';
}
