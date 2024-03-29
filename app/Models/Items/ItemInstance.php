<?php

namespace App\Models\Items;

use App\Models\Items\Fault\ItemFault;
use App\Models\Location;
use App\Models\Traits\HasFormattedIdentifier;
use Illuminate\Database\Eloquent\Model;
use Lorisleiva\LaravelSearchString\Concerns\SearchString;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class ItemInstance extends Model implements Searchable
{
    use HasFormattedIdentifier, SearchString;

    protected $guarded = [];
    protected $relations = ['type', 'location', 'faults'];
    protected $appends = ['identifier'];

    protected $searchStringColumns = [
        'id',
        'label' => [ 'searchable' => true ],
        'type_id' => 'type',
        'location_id' => 'location',
    ];

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

    public function faults()
    {
        return $this->hasMany(ItemFault::class, 'item_id', 'id');
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->identifier . (strlen($this->label) > 0 ? ': ' . $this->label : ''),
            url('/instances/' . $this->id)
        );
    }
}
