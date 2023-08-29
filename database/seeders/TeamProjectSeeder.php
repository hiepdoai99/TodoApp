<?php

namespace Database\Seeders;

use App\Enums\UserTypesEnum;
use App\Models\Team;
use App\Models\Status;
use App\Models\TeamProject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class  TeamProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TeamProject::query()->create([
            'team_id' => '1',
            'project_id'=> '1'
        ]);
        TeamProject::query()->create([
            'team_id' => '2',
            'project_id'=> '2'
        ]);
    }
}
