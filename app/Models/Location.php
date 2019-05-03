<?php

namespace App\Models;

use App\Models\Items\ItemInstance;
use App\Models\Items\ItemStockBalance;
use App\Models\Traits\HasFormattedIdentifier;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFormattedIdentifier;

    protected $guarded = [];
    protected $relations = ['stock', 'instances'];
    protected $appends = ['identifier', 'viewUrl'];

    public function getViewUrlAttribute()
    {
        return route('locations.view', $this);
    }

    public function getIdentifierPrefixLetter(): string
    {
        return 'L';
    }

    public function stock()
    {
        return $this->hasMany(ItemStockBalance::class, 'location_id', 'id');
    }

    public function instances()
    {
        return $this->hasMany(ItemInstance::class, 'location_id', 'id');
    }
}
