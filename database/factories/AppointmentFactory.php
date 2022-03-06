<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $doctors=User::whereHas('roles', function($q)
        {
            $q->where('name', 'doctor');
        })->get()->pluck('id');

        $patients=User::whereHas('roles', function($q)
        {
            $q->where('name', 'patient');
        })->get()->pluck('id');
        return [
            'doctor_id'=>$doctors->random(),
            'patient_id'=>$patients->random(),
            'date_created'=>$this->faker->dateTime(),
            'start_time'=>$this->faker->dateTime(),
            'end_time'=>$this->faker->dateTime(),
            'price'=>$this->faker->numberBetween(10,150),
            'canceled'=>$this->faker->boolean(),
            'cancellation_reason'=>$this->faker->text(),
        ];
    }
}
