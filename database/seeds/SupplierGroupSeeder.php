<?php

use App\SupplierGroup;
use Illuminate\Database\Seeder;

class SupplierGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SupplierGroup::create([
            'name' => 'punct de lucru / filiala',
            'name_en' => 'company branch',
            'user_id' => 1
        ]);

        SupplierGroup::create([
            'name' => 'furnizor extern',
            'name_en' => 'external supplier',
            'user_id' => 1
        ]);
    }
}
