<?php

use App\UserClass;
use Illuminate\Database\Seeder;

class UserClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserClass::create([
            'class' => 'SuperAdmin'
        ]);
        UserClass::create([
            'class' => 'Administrator'
        ]);
        UserClass::create([
            'class' => 'User'
        ]);
        UserClass::create([
            'class' => 'Viewer'
        ]);
    }
}
