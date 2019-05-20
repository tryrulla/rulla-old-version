<?php

namespace App\Models;

use App\Models\Traits\HasFormattedIdentifier;
use BeyondCode\Comments\Contracts\Commentator;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Lorisleiva\LaravelSearchString\Concerns\SearchString;

class User extends Authenticatable implements Commentator
{
    use HasFormattedIdentifier, Notifiable, SearchString;

    protected $fillable = ['username', 'name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $appends = ['identifier'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $searchStringColumns = [
        'id',

        'name' => [
            'searchable' => true,
        ],

        'username',
        'email',
    ];

    public function getIdentifierPrefixLetter(): string
    {
        return 'U';
    }

    /**
     * Check if a comment for a specific model needs to be approved.
     * @param mixed $model
     * @return bool
     */
    public function needsCommentApproval($model): bool
    {
        return false;
    }
}
