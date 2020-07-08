<?php

use App\ClaimStatus;
use Illuminate\Database\Seeder;

class ClaimStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClaimStatus::create([
            'status' => 'activa',
        ]);

        ClaimStatus::create([
            'status' => 'inchisa',
        ]);
    }
}
