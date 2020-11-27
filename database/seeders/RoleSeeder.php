<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id' => 0,
            'name' => 'Admin'
        ]);
        Role::create([
            'id' => 1,
            'name' => 'Kế Toán'
        ]); 
        Role::create([
            'id' => 2,
            'name' => 'Pháp Lý'
        ]);  
    }
}
