<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\OtherSettings;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

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

        $activity = Activity::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $activity->created_at);

        $this->assertEquals($datetime->format($dateFormat->value), $activity->getCreatedAt());
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

        $activity = Activity::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $activity->updated_at);

        $this->assertEquals($datetime->format($dateFormat->value), $activity->getUpdatedAt());
    }
}
