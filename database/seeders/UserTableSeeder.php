<?php

namespace Database\Seeders;

use App\Enums\UserTypesEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create([
            'first_name' => 'nguyen xuan ',
            'last_name' => ' hiep',
            'user_type' => (string)UserTypesEnum::member(),
            'email' => 'nguyenxuanhiepk49@gmail.com',
            'password' => Hash::make('1968'),
            'status' => '1',
            'is_email_verified' => '1',
        ]);
        User::query()->create([
            'first_name' => 'nguyen van ',
            'last_name' => ' test',
            'user_type' => (string)UserTypesEnum::member(),
            'email' => 'test@gmail.com',
            'password' => Hash::make('1968'),
            'status' => '1',
            'is_email_verified' => '1',
        ]);
        User::query()->create([
            'first_name' => 'nguyen trung ',
            'last_name' => ' hieu',
            'user_type' => (string)UserTypesEnum::member(),
            'email' => 'nguyentrunghieu987@gmail.com',
            'password' => Hash::make('1968'),
            'status' => '1',
            'is_email_verified' => '1',
        ]);

    }
}
