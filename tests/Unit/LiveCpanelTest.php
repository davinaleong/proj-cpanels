<?php

namespace Tests\Unit;

use App\Models\OtherSettings;
use App\Models\LiveCpanel;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LiveCpanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_a_project()
    {
        $live_cpanel = LiveCpanel::factory()->create();

        $this->assertInstanceOf(Project::class, $live_cpanel->project);
    }

    public function test_can_get_project_name()
    {
        $live_cpanel = LiveCpanel::factory()->create();

        $this->assertEquals($live_cpanel->project->name, $live_cpanel->getProjectName());
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

        $live_cpanel = LiveCpanel::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $live_cpanel->created_at);

        $this->assertEquals($datetime->format($dateFormat->value), $live_cpanel->getCreatedAt());
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

        $live_cpanel = LiveCpanel::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $live_cpanel->updated_at);

        $this->assertEquals($datetime->format($dateFormat->value), $live_cpanel->getUpdatedAt());
    }
}
