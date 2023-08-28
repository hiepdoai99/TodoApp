<?php

namespace Database\Seeders;

use App\Enums\UserTypesEnum;
use App\Models\Comment;
use App\Models\Status;
use App\Models\UserProject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserProject::query()->create([
            'user_id' => '1',
            'project_id' => '1',
        ]);
        UserProject::query()->create([
            'user_id' => '2',
            'project_id' => '1',
        ]);
        UserProject::query()->create([
            'user_id' => '3',
            'project_id' => '2',
        ]);
    }
}
