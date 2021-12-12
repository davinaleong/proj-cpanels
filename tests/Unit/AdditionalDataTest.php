<?php

namespace Tests\Unit;

use App\Models\AdditionalData;
use App\Models\AdditionalDataGroup;
use App\Models\OtherSettings;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdditionalDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_a_group()
    {
        $additional_data = AdditionalData::factory()->create();

        $this->assertInstanceOf(AdditionalDataGroup::class, $additional_data->additionalDataGroup);
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

        $additional_data = AdditionalData::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $additional_data->created_at);

        $this->assertEquals($datetime->format($dateFormat->value), $additional_data->getCreatedAt());
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

        $additional_data = AdditionalData::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $additional_data->updated_at);

        $this->assertEquals($datetime->format($dateFormat->value), $additional_data->getUpdatedAt());
    }
}
