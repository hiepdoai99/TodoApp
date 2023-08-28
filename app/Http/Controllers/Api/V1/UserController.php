<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\UserRegisterAction;
use App\Actions\UserUpdateAction;
use App\Enums\RolesEnum;
use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\TeamResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserProjectCollection;
use App\Http\Resources\UserResource;
use App\Models\Project;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;


class UserController extends Controller
{
    public function index(UserRequest $request)
    {
        $user = QueryBuilder::for(User::class)
            ->allowedIncludes(['roles', 'permissions','teams'])
            ->allowedFilters('name','email')
            ->paginate($request->per_page ?? 10)
            ->appends($request->all());
        return $this->respondSuccess(
            new UserCollection($user)
        );
    }

    public function store(RegisterRequest $request)
    {

        if ($user = app(UserRegisterAction::class)->execute($request->all())) {
            return $this->respondCreated(new UserResource($user));
        }
        return $this->respondError('Tao moi user that bai');
    }

    public function show(UserRequest $request, User $user)
    {
        $with = [];
        if ($request->has('include')) {
            $with = collect(explode(',', $request->include))->filter()->all();
        }
        return $this->respondSuccess(new UserResource($user->loadMissing($with)));
    }

    public function update(UserRequest $request, User $user)
    {
        if ($user = app(UserUpdateAction::class)->execute($user, $request->validated())) {
            return $this->respondSuccess(
                new UserResource($user)
            );
        }
        return $this->respondError('Loi cap nhat User');
    }

    public function destroy($id, UserRequest $request)
    {

        $todo = User::find($id);
        if ($todo->delete()) {
            return $this->respondOk(__('user.delete_success', ['resource', 'user ' . $todo->name]));
        }
        return $this->respondError(__('user.delete_fail', ['resource', 'user ' . $todo->name]));
    }
    public function showUser(UserRequest $request)
    {
        return auth()->user();
    }

    public function dashboard(Request $request)
    {
        $user = DB::table('users')->count();
        $task = DB::table('tasks')->count();
        $team = DB::table('teams')->count();
        $project = DB::table('projects')->count();
        return response()->json([
            'totalUser' => $user,
            'totalTeam' => $team,
            'totalTasks' => $task,
            'totalProject'=>$project,
        ]);
    }
}
