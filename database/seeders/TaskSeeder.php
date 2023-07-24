<?php

namespace Database\Seeders;

use App\Enums\UserTypesEnum;
use App\Models\Status;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::query()->create([
            'name' => 'Todo',
            'description' => 'Todo',
            'user_id' => '1',
            'status_id' => '1',
            'project_id' => '1',
            'assignee_id' => '2',
        ]);


    }
}
