<?php

namespace App\Models\Reservations;

use App\Models\Items\ItemInstance;
use Illuminate\Database\Eloquent\Model;

class ReservedItem extends Model
{
    protected $relations = ['reservation', 'item'];
    protected $guarded = [];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(ItemInstance::class, 'item_id', 'id');
    }
}
