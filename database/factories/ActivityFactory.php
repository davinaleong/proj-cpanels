<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'log' => $this->faker->sentence(),
            'link' => $this->faker->url(),
            'label' => $this->faker->sentence()
        ];
    }
}
