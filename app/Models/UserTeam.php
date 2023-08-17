<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserTeam extends Pivot
{
    use HasFactory;
    protected $table = "user_team";
    protected $fillable = ['user_id', 'team_id'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function teams()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
