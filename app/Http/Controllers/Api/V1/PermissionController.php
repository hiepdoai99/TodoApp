<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\RolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

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

}
