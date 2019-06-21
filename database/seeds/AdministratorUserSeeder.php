<?php

use Illuminate\Database\Seeder;
use App\User;

class AdministratorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => env('DEFAULT_ADMIN_USER_SEED', 'Administrator'),
            'email' => env('DEFAULT_ADMIN_EMAIL_SEED', 'admin@example.com'),
            'password' => bcrypt(env('DEFAULT_ADMIN_PWD_SEED', '12345678')),
        ]);
    }
}
