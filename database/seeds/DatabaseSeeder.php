<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdministratorUserSeeder::class);
        $this->call(CompanyInfoTableSeeder::class);
        $this->call(CompanyAssignmentSeeder::class);
        $this->call(SupplierGroupSeeder::class);
        $this->call(SupplierStatusSeeder::class);
        $this->call(VehiclesSeeder::class);
        $this->call(CertificationsSeeder::class);
        $this->call(PackagingMainSeeder::class);
        $this->call(UserClassesSeeder::class);
        $this->call(UserGroupsSeeder::class);
        $this->call(ClaimStatusSeeder::class);
    }
}
