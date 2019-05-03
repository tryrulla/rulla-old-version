<?php

namespace App\Models\Reservations;

use App\Models\Items\ItemStockType;
use App\Models\Traits\HasFormattedIdentifier;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFormattedIdentifier;

    protected $guarded = [];
    protected $relations = ['author'];
    protected $appends = ['identifier', 'viewUrl'];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'has_started' => 'boolean',
    ];

    public function getViewUrlAttribute()
    {
        return route('reservations.view', $this);
    }

    public function getStatusAttribute($value)
    {
        if ($value instanceof ItemStockType) {
            return $value;
        }

        return ReservationStatus::make($value);
    }

    public function getIdentifierPrefixLetter(): string
    {
        return 'R';
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
}
