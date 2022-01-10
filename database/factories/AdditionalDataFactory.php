<?php

namespace Database\Factories;

use App\Models\AdditionalData;
use App\Models\AdditionalDataGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdditionalDataFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdditionalData::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'additional_data_group_id' => AdditionalDataGroup::factory(),
            'key' => $this->faker->name(),
            'value' => $this->faker->word()
        ];
    }
}
