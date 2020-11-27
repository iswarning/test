<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContractStatus;

class ContractStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContractStatus::create([
            'id' => 0,
            'name' => 'Bỏ giữ chỗ'
        ]);
        ContractStatus::create([
            'id' => 1,
            'name' => 'Trả giữ chỗ'
        ]);
        ContractStatus::create([
            'id' => 2,
            'name' => 'Đang giữ chỗ'
        ]);
    }
}
