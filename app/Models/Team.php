<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
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
        return $this->belongsToMany(User::class, 'user_team');
    }
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'team_project');
    }
    public function created_by_user()
    {
        return $this->belongsTo(User::class,'created_by', 'id');
    }

}
