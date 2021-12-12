<?php

namespace Tests\Unit;

use App\Models\AdditionalDataGroup;
use App\Models\OtherSettings;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdditionalDataGroupTest extends TestCase
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

        $additonal_data_group = AdditionalDataGroup::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $additonal_data_group->created_at);

        $this->assertEquals($datetime->format($dateFormat->value), $additonal_data_group->getCreatedAt());
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

        $additonal_data_group = AdditionalDataGroup::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $additonal_data_group->updated_at);

        $this->assertEquals($datetime->format($dateFormat->value), $additonal_data_group->getUpdatedAt());
    }
}
