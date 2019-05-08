<?php

namespace App\Models\Items\Fault;

use App\Models\Items\ItemInstance;
use App\Models\Traits\HasFormattedIdentifier;
use Illuminate\Database\Eloquent\Model;

class ItemFault extends Model
{
    use HasFormattedIdentifier;

    protected $guarded = [];
    protected $relations = ['item'];
    protected $appends = ['identifier', 'viewUrl'];

    public function getIdentifierPrefixLetter(): string
    {
        return 'F';
    }

    public function getViewUrlAttribute()
    {
        return route('faults.view', $this);
    }

    public function getStatusAttribute($value): ItemFaultStatus
    {
        if ($value instanceof ItemFaultStatus) {
            return $value;
        }

        return ItemFaultStatus::make($value);
    }

    public function item()
    {
        return $this->belongsTo(ItemInstance::class, 'item_id', 'id');
    }
}
