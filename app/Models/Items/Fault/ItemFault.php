<?php

namespace App\Models\Items\Fault;

use App\Models\Items\ItemInstance;
use App\Models\Traits\HasFormattedIdentifier;
use Illuminate\Database\Eloquent\Model;
use Spatie\Enum\Laravel\HasEnums;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class ItemFault extends Model implements Searchable
{
    use HasFormattedIdentifier, HasEnums;

    protected $guarded = [];
    protected $relations = ['item'];
    protected $appends = ['identifier', 'viewUrl'];

    protected $enums = [
        'status' => ItemFaultStatus::class,
        'priority' => ItemFaultPriority::class,
    ];

    public function getIdentifierPrefixLetter(): string
    {
        return 'F';
    }

    public function getViewUrlAttribute()
    {
        return route('faults.view', $this);
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
            $this->view_url
        );
    }

}
