<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Driver;
use App\Models\Trip;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),

        ]);

        $companies = Company::factory(3)->create();

        foreach ($companies as $company) {
            $drivers = Driver::factory(5)->create(['company_id' => $company->id]);
            $vehicles = Vehicle::factory(5)->create(['company_id' => $company->id]);

            // create trips
            for ($i=0; $i<10; $i++) {
                Trip::factory()->create();
            }
        }
    }

}
