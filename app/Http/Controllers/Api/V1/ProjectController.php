<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserProjectCollection;
use App\Models\Project;
use App\Models\UserProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;


class ProjectController extends Controller
{
    public function index(ProjectRequest $request)
    {
        $project = QueryBuilder::for(Project::class)
            ->allowedIncludes(['team', 'tasks','users','created_by_user'])
            ->allowedFilters(['name'])
            ->paginate($request->per_page ?? 10)
            ->appends($request->all());

        return $this->respondSuccess(new ProjectCollection($project));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => ['required', 'string'],
            'team_id' => [ 'required', 'integer', 'min:1', 'exists:teams,id'],
        ]);
        $data['created_by'] = $user->id;

        $project = Project::create($data);

        if ($user) {
            UserProject::create([
                'project_id' => $project->id,
                'user_id' => $user->id
            ]);
        }
        return $this->respondCreated(
            new ProjectResource($project)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectRequest $request, project $project)
    {
        $with = [];
        if ($request->has('include')) {
            $with = collect(explode(',', $request->include))->filter()->all();
        }
        return $this->respondSuccess(new ProjectResource($project->loadMissing($with)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Project $project
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
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectRequest $request, project $project)
    {
        if ($project->delete()) {
            return $this->respondOk(__('Project.delete_success', ['resource', 'Project ' . $project->name]));
        }
        return $this->respondError(__('Project.delete_fail', ['resource', 'Project ' . $project->name]));
    }

    public function getProject(Request $request)
    {
        $id = $request->team_id ?? null;
        $query = Project::where('team_id', $id);
        $project = QueryBuilder::for($query)
            ->allowedFilters('name')
            ->paginate($request->per_page ?? 10)
            ->appends($request->all());
        return $this->respondSuccess( new ProjectCollection($project));
    }
}
