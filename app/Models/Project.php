<?php

namespace App\Models;

use App\Http\Resources\TeamResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'team_id',
        'created_by',
    ];

    public function getRules()
    {
        return [
            'name' => ['sometimes', 'required', 'string'],
            'created_by' => ['required', 'integer', 'min:1', 'exists:users,id'],
            'team_id' => [ 'required', 'integer', 'min:1', 'exists:teams,id'],
        ];
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_project');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    public function created_by_user()
    {
        return $this->belongsTo(User::class,'created_by', 'id');
    }
}
