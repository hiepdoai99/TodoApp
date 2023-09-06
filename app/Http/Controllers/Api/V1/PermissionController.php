<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\RolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;


class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->hasAnyRole([(string)RolesEnum::root(), (string)RolesEnum::admin()]))
        {
            return $this->respondSuccess(
                PermissionResource::collection(Permission::all())
            );
        }elseif ($user->hasAnyRole((string)RolesEnum::member())){
            return $this->respondSuccess(
                PermissionResource::collection($user->getDirectPermissions())
            );
        }
        return $this->respondForbidden('Bạn không có quyền xem Permission!');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function refresh()
    {
        if (Auth::hasUser() && Auth::user()->hasRoleAdmin()){
            return $this->respondOk(Artisan::call('permission:update'));
        }
        return $this->respondForbidden('Bạn không có quyền cập nhật Permission!');
    }
    public function store(PermissionRequest $request)
    {
        $permission = Permission::create([
            'name' => $request->input('name'),
        ]);

        // Cập nhật các quyền của quyền mới này (nếu có)
        if ($request->has('roles')) {
            $roles = $request->input('roles');
            $permission->syncRoles($roles);
        }

        // Trả về thông tin quyền vừa được tạo
        return response()->json(['message' => 'Permission created successfully', 'data' => $permission], 201);
    }

}
