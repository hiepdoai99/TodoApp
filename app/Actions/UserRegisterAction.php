<?php

namespace App\Actions;

use App\Enums\InvoiceStatusEnum;
use App\Enums\RolesEnum;
use App\Enums\UserTypesEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\QueueableAction\QueueableAction;

class UserRegisterAction
{
    use QueueableAction;

    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Prepare the action for execution, leveraging constructor injection.
    }

    /**
     * Execute the action.
     *
     * @return mixed
     */
    public function execute(array $dataUser)
    {
        $dataUser['password'] = Hash::make($dataUser['password']);
        $dataUser['user_type'] = (string)UserTypesEnum::member();
        $dataUser['roles'] = (string)RolesEnum::member();
        $dataUser['is_email_verified'] = 1;


        $user = new User();
        DB::beginTransaction();
        try {
            if ($user->fill($dataUser)->save() && !empty($dataUser['roles'])) {
                $user->assignRole($dataUser['roles']);
                $role = Role::findByName($dataUser['roles']);
                $user->givePermissionTo($role->getAllPermissions());
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
        return $user ;
    }
}
