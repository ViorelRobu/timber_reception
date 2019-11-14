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
            'name' => env('COMPANY_NAME_SEED', 'Nume Companie SRL'),
            'cui' => env('COMPANY_CUI_SEED', 'RO companie'),
            'j' => env('COMPANY_J_SEED', 'J companie'),
            'address' => env('COMPANY_ADDRESS_SEED', 'adresa companie'),
            'account_number' => env('COMPANY_BANK_ACCOUNT_SEED', 'numar cont RO11XX00000000000'),
            'bank' => env('COMPANY_BANK_SEED', 'nume banca'),
            'user_id' => 1,
        ]);
    }
}
