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
            'site_url' => 'https://www.exampledemo.com/',
            'admin_url' => 'https://www.exampledemo.com/admin/',
            'cpanel_url' => 'https://www.exampledemo.com:2083',
            'design_url' => 'https://www.exampledemo.com/design/',
            'programming_brief_url' => 'https://www.exampledemo.com/brief/',
            'cpanel_username' => 'example_cpanel',
            'cpanel_password' => 'cp password 123',
            'db_username' => 'example_db',
            'db_password' => 'db password 123',
            'db_name' => 'demo_db',
            'backend_username' => 'example',
            'backend_password' => 'admin password 123',
            'started_at' => '2021-01-01',
            'ended_at' => '2021-01-09'
        ];
    }
}
