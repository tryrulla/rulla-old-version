<?php

namespace App\Models\Items;

use App\Models\Location;
use Illuminate\Database\Eloquent\Model;

class ItemStockBalance extends Model
{
    protected $guarded = [];
    protected $relations = ['location', 'item'];

    protected $casts = [
        'updated_at' => 'datetime'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(ItemType::class, 'type_id', 'id');
    }
}
