<?php

namespace App\Models;

use App\Models\Traits\HasFormattedIdentifier;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFormattedIdentifier;
    use Notifiable;

    protected $fillable = ['username', 'name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $appends = ['identifier'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getIdentifierPrefixLetter(): string
    {
        return 'U';
    }
}
