<?php

namespace App\Models\Items\Fault;

use Spatie\Enum\Enum;

/**
 * @method static self unconfirmed()
 * @method static self open()
 * @method static self inService()
 * @method static self fixed()
 * @method static self closed()
 */
class ItemFaultStatus extends Enum
{
}
