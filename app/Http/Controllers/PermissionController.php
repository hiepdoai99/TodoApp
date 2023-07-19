<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Http\Resources\PermissionResource;
use Spatie\Permission\Traits\HasRoles;

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
        if ($user->hasAnyRole([
            (string)RolesEnum::root(), (string)RolesEnum::admin()
        ])){
            return $this->respondSuccess(
                PermissionResource::collection(Permission::all())
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
