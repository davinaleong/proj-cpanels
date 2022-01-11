<?php

namespace Tests\Unit;

use App\Models\OtherSettings;
use App\Models\DemoCpanel;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemoCpanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_a_project()
    {
        $demo_cpanel = DemoCpanel::factory()->create();

        $this->assertInstanceOf(Project::class, $demo_cpanel->project);
    }

    public function test_can_get_project_name()
    {
        $demo_cpanel = DemoCpanel::factory()->create();

        $this->assertEquals($demo_cpanel->project->name, $demo_cpanel->getProjectName());
    }

    public function test_can_get_formatted_created_at()
    {
        $dateFormat = OtherSettings::factory()->create([
            'key' => 'Date Format',
            'value' => 'd-m-Y H:i:s'
        ]);

        $dbDateFormat = OtherSettings::factory()->create([
            'key' => 'DB Date Format',
            'value' => 'Y-m-d H:i:s'
        ]);

        $demo_cpanel = DemoCpanel::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $demo_cpanel->created_at);

        $this->assertEquals($datetime->format($dateFormat->value), $demo_cpanel->getCreatedAt());
    }

    public function test_can_get_formatted_updated_at()
    {
        $dateFormat = OtherSettings::factory()->create([
            'key' => 'Date Format',
            'value' => 'd-m-Y H:i:s'
        ]);

        $dbDateFormat = OtherSettings::factory()->create([
            'key' => 'DB Date Format',
            'value' => 'Y-m-d H:i:s'
        ]);

        $demo_cpanel = DemoCpanel::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $demo_cpanel->updated_at);

        $this->assertEquals($datetime->format($dateFormat->value), $demo_cpanel->getUpdatedAt());
    }
}
