<?php

use App\SupplierStatus;
use Illuminate\Database\Seeder;

class SupplierStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SupplierStatus::create([
            'name' => 'activ',
            'name_en' => 'active',
            'user_id' => 1
        ]);

        SupplierStatus::create([
            'name' => 'inactiv',
            'name_en' => 'inactive',
            'user_id' => 1
        ]);
    }
}
