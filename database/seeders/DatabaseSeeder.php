<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Project::create(['name' => 'Riverside', 'description' => 'Dự án Riverside']);
        \App\Models\Project::create(['name' => 'Novaland', 'description' => 'Dự án Novaland']);
        \App\Models\Project::create(['name' => 'Diamond', 'description' => 'Dự án Diamond']);

        $this->call([
            PermissionSeeder::class ,
            RoleSeeder::class ,
            RoleHasPermissionSeeder::class ,
            UserSeeder::class ,
        ]);
    }
}
