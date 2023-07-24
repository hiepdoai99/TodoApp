<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory,  SoftDeletes;

    protected $fillable = [
        'content',
        'task_id',
        'user_id',
    ];

    public function getRules()
    {
        return [
            'content' => ['sometimes', 'required', 'string'],
            'user_id' => ['nullable', 'integer', 'min:1', 'exists:users,id'],
            'task_id' => ['nullable', 'integer', 'min:1', 'exists:tasks,id'],
        ];
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function task(){
        return $this->belongsTo(Task::class,'task_id');
    }
}
