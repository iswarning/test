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
            'name' => 'Admin'
        ]);
        Role::create([
            'name' => 'Kế Toán'
        ]);
        Role::create([
            'name' => 'Pháp Lý'
        ]);
        Role::create([
            'name' => 'Nhân viên'
        ]);
        Role::create([
            'name' => 'Khách hàng'
        ]);
    }
}
