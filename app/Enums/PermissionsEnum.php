<?php

namespace App\Enums;

use App\Traits\EnumUpperCase;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self user_create()
 * @method static self user_read()
 * @method static self user_update()
 * @method static self user_delete()
 *
 * @method static self role_create()
 * @method static self role_read()
 * @method static self role_update()
 * @method static self role_delete()
 *
 * @method static self permission_create()
 * @method static self permission_read()
 * @method static self permission_update()
 * @method static self permission_delete()
 *
 * @method static self status_create()
 * @method static self status_read()
 * @method static self status_update()
 * @method static self status_delete()
 *
 * @method static self team_create()
 * @method static self team_read()
 * @method static self team_update()
 * @method static self team_delete()
 *
 * @method static self project_create()
 * @method static self project_read()
 * @method static self project_update()
 * @method static self project_delete()
 *
 * @method static self task_create()
 * @method static self task_read()
 * @method static self task_update()
 * @method static self task_delete()
 *
 * @method static self image_create()
 * @method static self image_read()
 * @method static self image_update()
 * @method static self image_delete()
 *
 * @method static self comment_create()
 * @method static self comment_read()
 * @method static self comment_update()
 * @method static self comment_delete()
 *
 *
 * */

final class PermissionsEnum extends Enum
{
    use EnumUpperCase;
}
