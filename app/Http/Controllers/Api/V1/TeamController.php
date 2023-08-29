<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Http\Resources\TeamCollection;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use App\Models\UserTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;


class TeamController extends Controller
{
    public function index(TeamRequest $request)
    {
        $user = Auth::user();
        if (Auth::user()->hasRoleAdmin()) {
            $teams = QueryBuilder::for(Team::class)
                ->allowedIncludes(['projects', 'created_by_user', 'users'])
                ->allowedFilters(['name'])
                ->paginate($request->per_page ?? 10)
                ->appends($request->all());
            return $this->respondSuccess(new TeamCollection($teams));

        } else {
            $teams = $user->teams;
            return $this->respondSuccess(new TeamCollection($teams));
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
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string'],
        ]);
        $data['created_by'] = $user->id;

        $team = Team::create($data);

        if ($user) {
            UserTeam::create([
                'team_id' => $team->id,
                'user_id' => $user->id
            ]);
        }
        return $this->respondCreated(
            new TeamResource($team)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function show(TeamRequest $request, Team $team)
    {
        $with = [];
        if ($request->has('include')) {
            $with = collect(explode(',', $request->include))->filter()->all();
        }
        return $this->respondSuccess(new TeamResource($team->loadMissing($with)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function update(TeamRequest $request, Team $team)
    {
        $team->fill($request->validated())->save();
        return $this->respondSuccess(new TeamResource($team));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeamRequest $request, Team $team)
    {
        $user = Auth::user();
        if (Auth::user()->hasRoleAdmin() || $user->id = $team->created_by) {
            if ($team->delete()) {
                return $this->respondOk(__('team.delete_success', ['resource', 'Team ' . $team->name]));
            }
        }
        return $this->respondError(__('team.delete_fail', ['resource', 'Team ' . $team->name]));
    }

    public function removeUserTeam(Request $request){
        if (Auth::user()->hasRoleAdmin() || Auth::user()->hasRoleTeamLeader()){
            $team = $request->team_id ?? null;
            $user_id = $request->user_id ?? null;
            if ( $team && $user_id ){
                $ut = UserTeam::where([
                    ['team_id',$team],
                    ['user_id',$user_id]
                ])->first();
                if ($ut && $ut->delete()) {
                    return $this->respondOk(__('removeUserTeam.delete_success', ['resource', 'Remove user team success']));
                }
            }
        }

        return $this->respondError(__('removeUserTeam.delete_fail',['resource',  '']));

    }


}
