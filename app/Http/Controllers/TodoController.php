<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodoModel;
use Spatie\QueryBuilder\QueryBuilder;


class TodoController extends Controller
{
    public function index(Request $request){
        $todo = QueryBuilder::for(TodoModel::class)
                ->allowedFilters('name','description')
                ->allowedIncludes(['user', 'status'])
                ->paginate($request->per_page ?? 10)
                ->appends($request->all());
        return $this->respondSuccess($todo);
     }
     public function show(Request $request,$id){
        $todo = QueryBuilder::for(TodoModel::class)->find($id);
        return $this->respondSuccess($todo);
     }

     public function store(Request $request)
    {
        $todo = new TodoModel();

        $todo->name = $request->name;
        $todo->description = $request->description;
        $todo->status_id = $request->status_id;
        $todo->start_date = $request->start_date;
        $todo->end_date = $request->end_date;
        $todo->user_id = $request->user_id;

        $todo ->save();

        return $this->respondSuccess($todo);
    }

    public function edit(Request $request,$id)
    {
        $todo = TodoModel::find($id);
        $todo->name = $request->name;
        $todo->description = $request->description;
        $todo->status_id = $request->status_id;
        $todo->start_date = $request->start_date;
        $todo->end_date = $request->end_date;
        $todo->user_id = $request->user_id;
        $todo ->save();

        return $this->respondSuccess($todo);

    }

    public function destroy($id, Request $request)
    {

        $todo = TodoModel::find($id);
        if ($todo->delete()) {
            return $this->respondOk(__('todo.delete_success', ['resource', 'todo '.$todo->name]));
        }
        return $this->respondError(__('todo.delete_fail',['resource',  'todo '.$todo->name]));
    }
}
