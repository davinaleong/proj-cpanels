<?php

namespace Database\Factories;

use App\Models\OtherSettings;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OtherSettingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OtherSettings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'key' => $this->faker->word(),
            'value' => $this->faker->words(3, true)
        ];
    }
}
