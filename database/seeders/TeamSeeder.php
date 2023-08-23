<?php

namespace Database\Seeders;

use App\Enums\UserTypesEnum;
use App\Models\Team;
use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::query()->create([
            'name' => 'dev',
            'created_by'=> '1'
        ]);
    }
}
