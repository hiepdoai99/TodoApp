<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserProjectCollection;
use App\Models\Project;
use App\Models\Team;
use App\Models\TeamProject;
use App\Models\User;
use App\Models\UserProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;


class ProjectController extends Controller
{
    public function index(ProjectRequest $request)
    {
        $user = Auth::user();
        if(Auth::user()->hasRoleAdmin()){
            $project = QueryBuilder::for(Project::class)
                ->allowedIncludes(['teams', 'tasks','users','created_by_user'])
                ->allowedFilters(['name'])
                ->paginate($request->per_page ?? 10)
                ->appends($request->all());
            return $this->respondSuccess(new ProjectCollection($project));
        }else{
            $projects = $user->projects;
            return $this->respondSuccess(new ProjectCollection($projects));
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $teams = $request->teams ?? null;
        $user = Auth::user();
        $data = $request->validate([
            'name' => ['required', 'string'],
        ]);
        $data['created_by'] = $user->id;
        if($request->user_id){
            $data['created_by'] = $request->user_id;
        }

        $project = Project::create($data);

        if($request->user_id){
            UserProject::create([
                'project_id' => $project->id,
                'user_id' => $request->user_id
            ]);
        }if ($teams) {
            $usersInTeams = User::whereHas('teams', function ($query) use ($teams) {
                $query->whereIn('team_id', $teams);
            })->pluck('id');
            $datas = [];
            foreach ($usersInTeams as $item) {
                $datas[] = [
                    'user_id' => $item,
                    'project_id' => $project->id
                ];
            }
            $check = UserProject::insert($datas);

            foreach ($teams as $team) {
                TeamProject::create([
                    'team_id' => $team,
                    'project_id' => $project->id
                ]);
            }
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
        $user = Auth::user();
        if (Auth::user()->hasRoleAdmin() || $user->id = $project->created_by){
            if ($project->delete()) {
                return $this->respondOk(__('Project.delete_success', ['resource', 'Project ' . $project->name]));
            }
        }
        return $this->respondError(__('Project.delete_fail', ['resource', 'Project ' . $project->name]));
    }

    public function getProject(Request $request)
    {
        $user = Auth::user();
        $id = $request->team_id ?? null;
        if($id){
            $team = Team::find($id);
            $projects = $team->projects;
            return $this->respondSuccess(new ProjectCollection($projects));
        }else {
            $projects = $user->projects;
            return $this->respondSuccess(new ProjectCollection($projects));
        }
    }
    public function removeUserProject(Request $request){
        $user = Auth::user();
        $user_id = $request->user_id ?? null;
        $project = $request->project_id ?? null;
        $pro = Project::where('id',$project)->first();
        if (Auth::user()->hasRoleAdmin() || Auth::user()->hasRoleTeamLeader() || $user->id == $pro->created_by){
            if ( $user_id ){
                $up = UserProject::where([
                    ['project_id',$project],
                    ['user_id',$user_id]
                ])->first();
                if ( $up && $up->delete()) {
                    return $this->respondOk(__('removeUserInProject.delete_success', ['resource', 'Remove user Project success']));
                }
            }
        }
        return $this->respondError(__('removeUserInProject.delete_fail',['resource',  '']));
    }
}
