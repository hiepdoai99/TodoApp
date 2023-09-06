<?php

namespace App\Actions;

use App\Enums\RolesEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\QueueableAction\QueueableAction;

class UserUpdateAction
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
    public function execute(User $user, array $dataUser)
    {
        $au = auth()->user();
        if (!empty($dataUser['password'])) {
            $dataUser['password'] = Hash::make($dataUser['password']);
        }

        if ($au->hasRoleAdmin() && $au->id === $user->id) {
            return response()->json(['message' => 'không thực hiện được']);
        }

        if ($au->hasRoleAdmin() && $user->hasRoleRoot()) {
            return response()->json(['message' => 'không có quyền']);
        }

        DB::beginTransaction();
        try {
            if ($au->hasRoleMember() && $au->id === $user->id) {
                $user->fill($dataUser)->save();
                if (!empty($dataUser['roles'])) {
                    $user->syncRoles((string)RolesEnum::member());
                    $role = Role::findByName((string)RolesEnum::member());
                    $user->givePermissionTo($role->getAllPermissions());
                }

                DB::commit();
            }
            if ($au->hasRoleAdmin()) {
                $user->fill($dataUser)->save();
                $user->assignRole($dataUser['roles']);
                $role = Role::findByName($dataUser['roles']);
                $user->givePermissionTo($role->getAllPermissions());

                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return $user;
    }
}
