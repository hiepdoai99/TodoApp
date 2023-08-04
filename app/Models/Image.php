<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'image',

    ];

    public function getRules()
    {
        return [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function task(){
        return $this->belongsTo(Task::class,'task_id');
    }
}
