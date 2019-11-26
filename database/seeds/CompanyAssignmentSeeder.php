<?php

use App\CompanyAssignment;
use Illuminate\Database\Seeder;

class CompanyAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompanyAssignment::create([
            'user_id' => 1,
            'company_id' => 1
        ]);
    }
}
