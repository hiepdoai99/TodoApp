<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\RolesEnum;
use App\Enums\PermissionsEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        // create permissions
        $permissions = collect(PermissionsEnum::toValues())->map(function ($permission) {
            return [
                'name' => $permission,
                'guard_name' => config('auth.defaults.guard'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });
        Permission::insert($permissions->toArray());

        // create roles
        $roles = collect(RolesEnum::toValues())->map(function ($role) {
            return [
                'name' => $role,
                'guard_name' => config('auth.defaults.guard'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });
        Role::insert($roles->toArray());

        // create roles and assign created permissions
        $rootUser = User::where('email', 'nguyenxuanhiepk49@gmail.com')->first();
        $rootUser->assignRole((string)RolesEnum::root());
        $allPermissions = array_column($permissions->toArray(), 'name');
        Role::findByName((string)RolesEnum::root())
            ->givePermissionTo($allPermissions);
        Role::findByName((string)RolesEnum::admin())
            ->givePermissionTo($allPermissions);

        $rootUser->givePermissionTo($allPermissions);

        // add permission to role member
        $permissionMember = Permission::whereIn('id',[2,3,6,10,14,18,22,25,26,27,29,30,31,32,33,34,35,36])->get();
        Role::findByName((string)RolesEnum::member())
            ->givePermissionTo($permissionMember);

        $permissionTeamLeader = Permission::whereIn('id',[2,3,6,10,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36])->get();
        Role::findByName((string)RolesEnum::teamleader())
            ->givePermissionTo($permissionTeamLeader);

        $userMember = User::where('email', 'test@gmail.com')->first();
        $userMember->assignRole((string)RolesEnum::member())
            ->givePermissionTo($permissionMember);

    }
}
