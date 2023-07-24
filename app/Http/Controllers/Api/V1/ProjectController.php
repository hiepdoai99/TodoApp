<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Spatie\QueryBuilder\QueryBuilder;


class ProjectController extends Controller
{
    public function index(ProjectRequest $request)
    {
        $project = QueryBuilder::for(Project::class)
            ->allowedFilters(['name'])
            ->paginate($request->per_page ?? 10)
            ->appends($request->all());

        return $this->respondSuccess(new ProjectCollection($project));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        return $this->respondCreated(
            new ProjectResource(Project::create($request->validated()))
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectRequest $request, project $project)
    {
        return $this->respondSuccess(new ProjectResource($project));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, project $project)
    {
        $project->fill($request->validated())->save();
        return $this->respondSuccess(new ProjectResource($project));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectRequest $request, project $project)
    {
        if ($project->delete()) {
            return $this->respondOk(__('Project.delete_success', ['resource', 'Project '.$project->name]));
        }
        return $this->respondError(__('Project.delete_fail',['resource',  'Project '.$project->name]));
    }
}
