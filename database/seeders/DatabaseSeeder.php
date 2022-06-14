<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Service;
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
        // \App\Models\User::factory(10)->create();
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(RoleUserSeeder::class);
        $this->call(ScheduleSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(AppointmentSeeder::class);
        $this->call(AppointmentServiceSeeder::class);
    }
}
