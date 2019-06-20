<?php

use Illuminate\Database\Seeder;
use App\CompanyInfo;

class CompanyInfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompanyInfo::create([
            'name' => 'Nume companie SRL',
            'cui' => 'RO companie',
            'j' => 'j companie',
            'address' => 'adresa companie',
            'account_number' => 'numar cont RO11XX00000000000',
            'bank' => 'nume banca',
            'user_id' => 1,
        ]);
    }
}
