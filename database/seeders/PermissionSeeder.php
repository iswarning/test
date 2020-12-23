<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Kế Toán
        Permission::create([
            'name' => 'Kế toán trưởng',
            'role_id' => 2
        ]);
        Permission::create([
            'name' => 'Thủ quỹ',
            'role_id' => 2
        ]);
        Permission::create([
            'name' => 'Kế toán hợp đồng',
            'role_id' => 2
        ]);
        Permission::create([
            'name' => 'Kế toán nội bộ',
            'role_id' => 2
        ]);
        Permission::create([
            'name' => 'Kế toán công nợ',
            'role_id' => 2
        ]);
        Permission::create([
            'name' => 'Kế toán thuế',
            'role_id' => 2
        ]);

        // Pháp Lý
        Permission::create([
            'name' => 'Trưởng phòng pháp lý',
            'role_id' => 3
        ]);
        Permission::create([
            'name' => 'Nhân viên pháp lý',
            'role_id' => 3
        ]);
    }
}
