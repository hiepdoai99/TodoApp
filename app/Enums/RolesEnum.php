<?php

namespace App\Enums;

use App\Traits\EnumUpperCase;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self root()
 * @method static self admin()
 * @method static self teamleader()
 * @method static self projectleader()
 * @method static self member()
 */
final class RolesEnum extends Enum
{
    use EnumUpperCase;
}
