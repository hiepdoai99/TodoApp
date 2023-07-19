<?php

namespace App\Enums;

use App\Traits\EnumUpperCase;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self member()
 * @method static self customer()
 */

final class UserTypesEnum extends Enum
{
    use EnumUpperCase;

}
