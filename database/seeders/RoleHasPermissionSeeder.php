<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleHasPermission;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1;$i <= 6;$i++)
        {
            RoleHasPermission::create([
                'role_id' => 2,
                'permission_id' => $i
            ]);
        }

        for($i = 7;$i <= 8;$i++)
        {
            RoleHasPermission::create([
                'role_id' => 3,
                'permission_id' => $i
            ]);
        }
    }
}
