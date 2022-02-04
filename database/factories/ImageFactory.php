<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Folder;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'folder_id' => Folder::factory(),
            'name' => 'Test image',
            'filename' => 'image.png'
        ];
    }
}
