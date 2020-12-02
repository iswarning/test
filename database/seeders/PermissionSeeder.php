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
            'name' => 'Kế Toán Trưởng',
            'role_id' => 2
        ]);
        Permission::create([
            'name' => 'Thủ Quỹ',
            'role_id' => 2
        ]);
        Permission::create([
            'name' => 'Kế Toán Hợp Đồng',
            'role_id' => 2
        ]);
        Permission::create([
            'name' => 'Kế Toán Nội Bộ',
            'role_id' => 2
        ]);
        Permission::create([
            'name' => 'Kế Toán Công Nợ',
            'role_id' => 2
        ]);
        Permission::create([
            'name' => 'Kế Toán Thuế',
            'role_id' => 2
        ]);

        // Pháp Lý
        Permission::create([
            'name' => 'Trưởng Phòng Pháp Lý',
            'role_id' => 3
        ]);
        Permission::create([
            'name' => 'Nhân Viên Pháp Lý',
            'role_id' => 3
        ]);
    }
}
