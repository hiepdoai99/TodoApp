<?php

namespace Database\Seeders;

use App\Enums\UserTypesEnum;
use App\Models\Project;
use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::query()->create([
            'name' => 'Test',
        ]);




    }
}
