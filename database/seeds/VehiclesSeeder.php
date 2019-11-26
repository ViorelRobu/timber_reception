<?php

use App\Vehicle;
use Illuminate\Database\Seeder;

class VehiclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vehicle::create([
            'name' => 'AUTO',
            'name_en' => 'AUTO',
            'user_id' => 1
        ]);

        Vehicle::create([
            'name' => 'VAGON',
            'name_en' => 'WAGON',
            'user_id' => 1
        ]);
    }
}
