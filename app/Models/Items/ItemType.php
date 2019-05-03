<?php

namespace App\Models\Items;

use App\Models\Traits\HasFormattedIdentifier;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

class ItemType extends Model
{
    use HasFormattedIdentifier;

    protected $guarded = [];
    protected $relations = ['stockBalances'];
    protected $appends = ['identifier', 'viewUrl', 'name'];

    public function getViewUrlAttribute()
    {
        return route('types.view', $this);
    }

    public function getNameAttribute()
    {
        return $this->manufacturer . ' ' . $this->model;
    }

    public function getStockTypeAttribute($value)
    {
        if ($value instanceof ItemStockType) {
            return $value;
        }

        return ItemStockType::make($value);
    }

    public function getIdentifierPrefixLetter(): string
    {
        return 'T';
    }

    public function instances()
    {
        return $this->hasMany(ItemInstance::class, 'type_id', 'id');
    }

    public function stockBalances()
    {
        return $this->hasMany(ItemStockBalance::class, 'type_id', 'id')
            ->with('location');
    }

    public function scopeHasStockIn($query, $locationId)
    {
        return $query->whereHas('stockBalances', function ($stockQuery) use ($locationId) {
            return $stockQuery->where('location_id', '=', $locationId);
        });
    }
}
