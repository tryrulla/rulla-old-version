<?php

namespace App\Models\Items;

use App\Models\Location;
use App\Models\Traits\HasFormattedIdentifier;
use Illuminate\Database\Eloquent\Model;

class ItemInstance extends Model
{
    use HasFormattedIdentifier;

    protected $guarded = [];
    protected $relations = ['type', 'location'];
    protected $appends = ['identifier', 'viewUrl'];

    public function getViewUrlAttribute()
    {
        return route('instances.view', $this);
    }

    public function getIdentifierPrefixLetter(): string
    {
        return 'I';
    }

    public function type()
    {
        return $this->belongsTo(ItemType::class, 'type_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
}
