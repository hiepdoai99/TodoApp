<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Spatie\QueryBuilder\QueryBuilder;



class TaskController extends Controller
{
    public function index(TaskRequest $request)
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedIncludes(['user','project','status','assignee'])
            ->allowedFilters(['name'])
            ->paginate($request->per_page ?? 10)
            ->appends($request->all());

        if($request->filled('search')){
            $tasks = Task::search($request->search)
                ->paginate($request->per_page ?? 10)
                ->appends($request->all());;
            return response()->json($tasks);
        }
        return $this->respondSuccess(new TaskCollection($tasks));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        return $this->respondCreated(
            new TaskResource(Task::create($request->validated()))
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(TaskRequest $request, Task $task)
    {
        return $this->respondSuccess(new TaskResource($task));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, Task $task)
    {
        $task->fill($request->validated())->save();
        return $this->respondSuccess(new TaskResource($task));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskRequest $request, Task $task)
    {
        if ($task->delete()) {
            return $this->respondOk(__('Task.delete_success', ['resource', 'Task '.$task->name]));
        }
        return $this->respondError(__('Task.delete_fail',['resource',  'Task '.$task->name]));
    }
}
