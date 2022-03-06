<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $duration=array(15,30,45,60,75,90);
        $prices=array(20.0,30.0,50.0,100.0,10.0,75.0);

        return [
            'name'=>$this->faker->streetName,
            'duration'=>$this->faker->randomElement($duration),
            'price'=>$this->faker->randomElement($prices),
        ];
    }
}
