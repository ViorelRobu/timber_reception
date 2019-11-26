<?php

use App\PackagingMain;
use Illuminate\Database\Seeder;

class PackagingMainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PackagingMain::create([
            'name' => 'Carton-Hartie',
            'user_id' => 1
        ]);
        PackagingMain::create([
            'name' => 'Lemn',
            'user_id' => 1
        ]);
        PackagingMain::create([
            'name' => 'Folie',
            'user_id' => 1
        ]);
        PackagingMain::create([
            'name' => 'Banda PP',
            'user_id' => 1
        ]);
        PackagingMain::create([
            'name' => 'Metalice',
            'user_id' => 1
        ]);

    }
}
