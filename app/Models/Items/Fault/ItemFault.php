<?php

namespace App\Models\Items\Fault;

use App\Models\Items\ItemInstance;
use App\Models\Traits\HasFormattedIdentifier;
use Illuminate\Database\Eloquent\Model;
use Spatie\Enum\Laravel\HasEnums;

class ItemFault extends Model
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
}
