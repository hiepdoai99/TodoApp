<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'image',
        'user_id',
        'task_id',
    ];

    public function getRules()
    {
        return [
            'description' => ['sometimes', 'required', 'string'],
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
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
