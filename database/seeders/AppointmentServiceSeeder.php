<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Database\Seeder;

class AppointmentServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services=Service::all();

        Appointment::all()->each(function ($appointment) use ($services){
            $appointment->services()->attach($services->random(1)->pluck('id'));
        });
    }
}
