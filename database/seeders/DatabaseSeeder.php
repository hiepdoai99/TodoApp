<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserTableSeeder::class);
        $this->call(RoleAndPermissionSeeder::class);
        $this->call(StatusTableSeeder::class);
        $this->call(TeamSeeder::class);
        $this->call(UserTeamSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(UserProjectSeeder::class);
        $this->call(TeamProjectSeeder::class);
        $this->call(TaskSeeder::class);
        $this->call(CommentSeeder::class);
    }
}
