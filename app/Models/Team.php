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
    ];

    public function getRules()
    {
        return [
            'name' => ['sometimes', 'required', 'string'],
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

    protected static function boot() {
        parent::boot();


        static::creating(function ($team) {
            // Kiểm tra xem đã có người dùng đăng nhập hay chưa
            if (auth()->check()) {
                // Lấy id của người dùng đang đăng nhập và gán cho trường created_by
                $team->created_by = auth()->id();
            }
        });
    }

}
