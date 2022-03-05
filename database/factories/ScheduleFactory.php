<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ScheduleFactory extends Factory
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

        $start=$this->faker->dateTimeBetween('now','+30 minutes');
        $end=$this->faker->dateTimeBetween($start,'+30 minutes');
        return [
            'from'=>$start,
            'to'=>$end,
            'user_id'=>$this->faker->randomElement($doctors)
        ];

    }
}
