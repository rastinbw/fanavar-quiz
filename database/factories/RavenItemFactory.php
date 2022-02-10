<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RavenItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'qo_image' => "https://testotype.com/article%20images/4d890f64-8e70-4ad7-af92-478c28380b0f/1.PNG",
            'correct_option_number' => $this->faker->numberBetween(1, 6),
        ];
    }

}
