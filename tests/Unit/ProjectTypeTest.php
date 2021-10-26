<?php

namespace Tests\Unit;

use App\Models\OtherSettings;
use App\Models\ProjectType;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTypeTest extends TestCase
{
    use RefreshDatabase;

    /** @group new */
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

        $projectType = ProjectType::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $projectType->created_at);

        $this->assertEquals($datetime->format($dateFormat->value), $projectType->getCreatedAt());
    }

    /** @group new */
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

        $projectType = ProjectType::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $projectType->updated_at);

        $this->assertEquals($datetime->format($dateFormat->value), $projectType->getUpdatedAt());
    }
}
