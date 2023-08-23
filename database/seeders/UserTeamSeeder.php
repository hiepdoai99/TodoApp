<?php

namespace Database\Seeders;

use App\Enums\UserTypesEnum;
use App\Models\UserTeam;
use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserTeam::query()->create([
            'team_id' => '1',
            'user_id' => '1',
        ]);




    }
}
