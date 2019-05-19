<?php

namespace App\Models;

use App\Models\Items\ItemInstance;
use App\Models\Items\ItemStockBalance;
use App\Models\Traits\HasFormattedIdentifier;
use Illuminate\Database\Eloquent\Model;
use Lorisleiva\LaravelSearchString\Concerns\SearchString;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Location extends Model implements Searchable
{
    use HasFormattedIdentifier, SearchString;

    protected $guarded = [];
    protected $relations = ['stock', 'instances'];
    protected $appends = ['identifier'];

    protected $searchStringColumns = [
        'id',

        'name' => [
            'searchable' => true,
        ],

        'parent_id' => 'parent',
    ];

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

    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id', 'id');
    }

    public function parents()
    {
        return $this->parent()->with('parents');
    }

    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id', 'id');
    }

    public function childrenTree()
    {
        return $this->children()->with('childrenTree');
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->identifier . (strlen($this->name) > 0 ? ': ' . $this->name : ''),
            url('/locations/' . $this->id)
        );
    }
}
