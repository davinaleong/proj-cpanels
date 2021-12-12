<?php

namespace Database\Factories;

use App\Models\AdditionalDataGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdditionalDataGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdditionalDataGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name()
        ];
    }
}
