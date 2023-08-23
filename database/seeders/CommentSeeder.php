<?php

namespace Database\Seeders;

use App\Enums\UserTypesEnum;
use App\Models\Comment;
use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Comment::query()->create([
            'content' => 'good job',
            'user_id' => '1',
            'task_id' => '1',
        ]);
        Comment::query()->create([
            'content' => 'so bad',
            'user_id' => '1',
            'task_id' => '1',
        ]);
        Comment::query()->create([
            'content' => 'very good',
            'user_id' => '1',
            'task_id' => '1',
        ]);
    }
}
