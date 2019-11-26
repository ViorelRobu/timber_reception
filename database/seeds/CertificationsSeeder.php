<?php

use App\Certification;
use Illuminate\Database\Seeder;

class CertificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Certification::create([
            'name' => '100% PEFC',
            'name_en' => '100%-PEFC certified',
            'user_id' => 1
        ]);

        Certification::create([
            'name' => 'FSC 100%',
            'name_en' => 'FSC 100% - certified',
            'user_id' => 1
        ]);

        Certification::create([
            'name' => 'Surse controlate',
            'name_en' => 'Other material - internal verification accomplished',
            'user_id' => 1
        ]);

        Certification::create([
            'name' => 'PEFC surse controlate',
            'name_en' => 'PEFC controlled sources',
            'user_id' => 1
        ]);
    }
}
