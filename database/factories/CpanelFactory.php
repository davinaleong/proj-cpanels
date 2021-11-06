<?php

namespace Database\Factories;

use App\Models\Cpanel;
use App\Models\Image;
use App\Models\ProjectType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class CpanelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cpanel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'project_type_id' => ProjectType::factory(),
            'image_id' => Image::factory(),
            'name' => $this->faker->name(),
            'site_url' => 'https://www.example.com/',
            'admin_url' => 'https://www.example.com/admin/',
            'cpanel_url' => 'https://www.example.com:2083',
            'cpanel_username' => 'username',
            'cpanel_password' => Hash::make('password123'),
            'backend_username' => 'johndoe',
            'backend_password' => Hash::make('password')
        ];
    }
}
