<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;


class Task extends Model
{
    use HasFactory, SoftDeletes,Searchable;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'status_id',
        'project_id',
        'assignee_id',
        'start_date',
        'end_date',
    ];

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description
        ];
    }

    public function getRules()
    {
        return [
            'name' => ['sometimes', 'required', 'string'],
            'description' => ['sometimes', 'required', 'string'],
            'user_id' => ['nullable', 'integer', 'min:1', 'exists:users,id'],
            'assignee_id' => ['nullable', 'integer', 'min:1', 'exists:users,id'],
            'status_id' => ['nullable', 'integer', 'min:1', 'exists:status,id'],
            'project_id' => ['nullable', 'integer', 'min:1', 'exists:projects,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date','after_or_equal:start_date']
        ];
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function assignee(){
        return $this->belongsTo(User::class,'assignee_id', 'id');
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }
}
