<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Image;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;


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
                ->appends($request->all());
            return $this->respondSuccess(new TaskCollection($tasks));
        }
        return $this->respondSuccess(new TaskCollection($tasks));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        $user = auth()->user();
        $id = $request->assigner_id;
        $asn = User::find($id);
        if ($user->teams){
            $task = Task::create($request->all());
            $image = $request->image ?? null;
            if ($image) {
                list($type, $data) = explode(';', $image);
                list(, $data)      = explode(',', $data);
                $type = str_replace('data:image/','',$type);
                $rand = substr(md5(microtime()),rand(0,26), 20);
                $data = base64_decode($data);
                $imageName = $rand.'.'.$type;
                Storage::disk('public')->put($imageName, $data);
                Image::create([
                    'image' => $imageName,
                    'task_id' => $task->id
                ]);
            }

            return $this->respondCreated(
                new TaskResource($task)
            );
        }
        return $this->respondError(__('create task fail',['resource',  'Task ']));



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
