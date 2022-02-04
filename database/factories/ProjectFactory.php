<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Image;
use App\Models\ProjectType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

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
            'project_executive' => $this->faker->name(),
            'is_full_project' => $this->faker->boolean(50),
            'notes' => $this->faker->paragraph(3)
        ];
    }
}
