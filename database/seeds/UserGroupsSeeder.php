<?php

use App\UserGroup;
use Illuminate\Database\Seeder;

class UserGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserGroup::create([
            'class_id' => 1,
            'user_id' => 1
        ]);
    }
}
