<?php

namespace App\Models\Items;

use App\Models\Traits\HasFormattedIdentifier;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class ItemType extends Model implements Searchable
{
    use HasFormattedIdentifier;

    protected $guarded = [];
    protected $relations = ['stockBalances'];
    protected $appends = ['identifier', 'name'];

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

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->identifier . (strlen($this->name) > 0 ? ': ' . $this->name : ''),
            url('/types/' . $this->id)
        );
    }
}
