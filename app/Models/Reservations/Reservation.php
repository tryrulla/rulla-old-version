<?php

namespace App\Models\Reservations;

use App\Models\Traits\HasFormattedIdentifier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Lorisleiva\LaravelSearchString\Concerns\SearchString;

class Reservation extends Model
{
    use HasFormattedIdentifier, SearchString;

    protected $guarded = [];
    protected $relations = ['author', 'items'];
    protected $appends = ['identifier', 'status'];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'started' => 'boolean',
        'cancelled' => 'boolean',
    ];

    protected $searchStringColumns = [
        'id',
        'starts_at',
        'ends_at',

        'started' => [
            'boolean' => true,
        ],

        'approval_status',
        'author_id' => 'author',

        'cancelled' => [
            'boolean' => true,
        ],
    ];

    public function getApprovalStatusAttribute($value): ReservationApprovalStatus
    {
        if ($value instanceof ReservationApprovalStatus) {
            return $value;
        }

        return ReservationApprovalStatus::make($value);
    }

    public function getStatusAttribute(): ReservationStatus
    {
        if ($this->cancelled) {
            return ReservationStatus::cancelled();
        }

        /** @var ReservationApprovalStatus $approvalStatus */
        $approvalStatus = $this->approval_status;
        if ($approvalStatus->isEqual(ReservationApprovalStatus::awaiting())) {
            return ReservationStatus::awaitingApproval();
        } else if ($approvalStatus->isEqual(ReservationApprovalStatus::rejected())) {
            return ReservationStatus::rejected();
        }

        if ($this->started) {
            if ($this->items->filter(function ($item) {
                /** @var ReservedItem $item */
                return !$item->status->isReturned();
            })->count() === 0) {
                return ReservationStatus::completed();
            }

            if ($this->ends_at->isBefore(Carbon::now())) {
                return ReservationStatus::overdue();
            }

            return ReservationStatus::out();
        }

        if ($this->ends_at->isBefore(Carbon::now())) {
            return ReservationStatus::completed();
        }

        return ReservationStatus::planned();
    }

    public function getIdentifierPrefixLetter(): string
    {
        return 'R';
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(ReservedItem::class, 'reservation_id', 'id');
    }
}
