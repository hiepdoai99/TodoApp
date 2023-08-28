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
        'created_by',
    ];

    public function getRules()
    {
        return [
            'name' => ['sometimes', 'required', 'string'],
            'created_by' => ['required', 'integer', 'min:1', 'exists:users,id'],
        ];
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_project');
    }
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_project');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }


    public function created_by_user()
    {
        return $this->belongsTo(User::class,'created_by', 'id');
    }
    protected static function boot() {
        parent::boot();

        static::deleting(function ($project) {
            $project->tasks()->delete();
        });
    }
}
