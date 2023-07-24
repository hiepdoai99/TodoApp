<?php

namespace Database\Seeders;

use App\Enums\UserTypesEnum;
use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::query()->create([
            'name' => 'Todo',
        ]);
        Status::query()->create([
            'name' => ' Ongoing ',
        ]);
        Status::query()->create([
            'name' => ' Done ',
        ]);
        Status::query()->create([
            'name' => ' Abort ',
        ]);
        Status::query()->create([
            'name' => ' Delay ',
        ]);



    }
}
