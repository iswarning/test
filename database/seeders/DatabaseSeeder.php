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
        $faker = \Faker\Factory::create();
        for($i = 0; $i < 50; $i++) {
            \App\Models\Customers::create([
                'name' => $faker->name(),
                'cmnd' => $faker->regexify('[A-Za-z0-9]{10}'),
                'address' => $faker->address(),
                'birthday' => $faker->date(),
                'household' => $faker->address(),
                'phone' => $faker->phoneNumber()
            ]);
        }

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
