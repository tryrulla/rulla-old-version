<?php

namespace App\Models;

use App\Models\Items\ItemInstance;
use App\Models\Items\ItemStockBalance;
use App\Models\Traits\HasFormattedIdentifier;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Location extends Model implements Searchable
{
    use HasFormattedIdentifier;

    protected $guarded = [];
    protected $relations = ['stock', 'instances'];
    protected $appends = ['identifier'];

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

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->identifier . (strlen($this->name) > 0 ? ': ' . $this->name : ''),
            $this->view_url
        );
    }
}
