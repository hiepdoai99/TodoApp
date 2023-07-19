<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TodoModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'status_id', 'start_date', 'end_date', 'user_id'
    ];

    public static array $statuses = [
        'slacking', 'done', 'late','unfinished'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class  );
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
