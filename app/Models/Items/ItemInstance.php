<?php

namespace App\Models\Items;

use App\Models\Traits\HasFormattedIdentifier;
use Illuminate\Database\Eloquent\Model;

class ItemInstance extends Model
{
    use HasFormattedIdentifier;

    protected $guarded = [];
    protected $relations = ['type'];
    protected $appends = ['identifier', 'viewUrl'];

    public function getViewUrlAttribute()
    {
        return route('instances.view', $this);
    }

    public function getIdentifierPrefixLetter(): string
    {
        return 'I';
    }

    public function type()
    {
        return $this->belongsTo(ItemType::class, 'type_id', 'id');
    }
}
