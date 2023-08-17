<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function getRules()
    {
        return [
            'name' => ['sometimes', 'required', 'string']
        ];
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_team');
    }
}
