<?php

namespace App\Models\Reservations;

use Spatie\Enum\Enum;

/**
 * @method static self awaiting()
 * @method static self rejected()
 * @method static self approved()
 */
class ReservationApprovalStatus extends Enum
{}
