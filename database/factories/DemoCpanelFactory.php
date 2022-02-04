<?php

namespace Database\Factories;

use App\Models\DemoCpanel;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class DemoCpanelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DemoCpanel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'project_id' => Project::factory(),
            'site_url' => $this->faker->url(),
            'admin_url' => $this->faker->url(),
            'cpanel_url' => $this->faker->url(),
            'design_url' => $this->faker->url(),
            'programming_brief_url' => $this->faker->url(),
            'cpanel_username' => $this->faker->word(),
            'cpanel_password' => $this->faker->word(),
            'db_username' => $this->faker->word(),
            'db_password' => $this->faker->word(),
            'db_name' => $this->faker->word(),
            'backend_username' => $this->faker->word(),
            'backend_password' => $this->faker->word(),
            'started_at' => $this->faker->date('j M Y'),
            'ended_at' => $this->faker->date('j M Y')
        ];
    }
}
