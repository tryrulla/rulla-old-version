<?php

namespace App\Models\Reservations;

use Spatie\Enum\Enum;

/**
 * @method static self inStock()
 * @method static self out()
 * @method static self returned()
 */
class ReservedItemStatus extends Enum
{}
