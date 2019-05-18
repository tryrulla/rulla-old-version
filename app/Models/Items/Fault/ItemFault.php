<?php

namespace App\Models\Items\Fault;

use App\Models\Items\ItemInstance;
use App\Models\Traits\HasFormattedIdentifier;
use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Database\Eloquent\Model;
use Spatie\Enum\Laravel\HasEnums;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class ItemFault extends Model implements Searchable
{
    use HasFormattedIdentifier, HasEnums, HasComments;

    protected $guarded = [];
    protected $relations = ['item'];
    protected $appends = ['identifier'];

    protected $enums = [
        'status' => ItemFaultStatus::class,
        'priority' => ItemFaultPriority::class,
    ];

    public function getIdentifierPrefixLetter(): string
    {
        return 'F';
    }

    public function item()
    {
        return $this->belongsTo(ItemInstance::class, 'item_id', 'id');
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->identifier . ': ' . $this->name,
            url('/instances/' . $this->item->id . '/fault/' . $this->id)
        );
    }

}
