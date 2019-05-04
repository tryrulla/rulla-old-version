<?php

namespace App\Models\Reservations;

use Spatie\Enum\Enum;

/**
 * @method static self awaitingApproval()
 * @method static self rejected()
 * @method static self planned()
 * @method static self out()
 * @method static self completed()
 */
class ReservationStatus extends Enum
{}
