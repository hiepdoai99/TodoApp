<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index(Request $request){
        $user = QueryBuilder::for(User::class)
                ->allowedFilters('name')
                ->allowedIncludes([ 'todomodels'])
                ->paginate($request->per_page ?? 10)
                ->appends($request->all());
        return $this->respondSuccess($user);
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $password =  Hash::make($request->password);
        $user->password = $password;
        $user ->save();

        return $this->respondSuccess($user);
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user ->save();

        return $this->respondSuccess($user);
    }
    public function destroy($id, Request $request)
    {

        $todo = User::find($id);
        if ($todo->delete()) {
            return $this->respondOk(__('user.delete_success', ['resource', 'user '.$todo->name]));
        }
        return $this->respondError(__('user.delete_fail',['resource',  'user '.$todo->name]));
    }


}
