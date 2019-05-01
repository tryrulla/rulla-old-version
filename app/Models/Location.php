<?php

namespace App\Models;

use App\Models\Traits\HasFormattedIdentifier;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFormattedIdentifier;

    protected $guarded = [];
    protected $appends = ['identifier', 'viewUrl'];

    public function getViewUrlAttribute()
    {
        return route('locations.view', $this);
    }

    public function getIdentifierPrefixLetter(): string
    {
        return 'L';
    }
}
