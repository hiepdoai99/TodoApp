<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamProject extends Pivot
{
    use HasFactory,SoftDeletes;

    protected $table = "team_project";
    protected $fillable = ['team_id', 'project_id'];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
