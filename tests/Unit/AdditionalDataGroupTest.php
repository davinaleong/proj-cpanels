<?php

namespace Tests\Unit;

use App\Models\AdditionalDataGroup;
use App\Models\AdditionalData;
use App\Models\OtherSettings;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdditionalDataGroupTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_many_additional_data()
    {
        $additional_data_count = 3;
        $additional_data_group = AdditionalDataGroup::factory()->create();
        AdditionalData::factory()
            ->for($additional_data_group)
            ->count($additional_data_count)
            ->create([
                'additional_data_group_id' => $additional_data_group->id
            ]);

        $this->assertEquals($additional_data_count, count($additional_data_group->additionalData));
        $this->assertInstanceOf(AdditionalData::class, $additional_data_group->additionalData[0]);
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

        $additional_data_group = AdditionalDataGroup::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $additional_data_group->created_at);

        $this->assertEquals($datetime->format($dateFormat->value), $additional_data_group->getCreatedAt());
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

        $additional_data_group = AdditionalDataGroup::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $additional_data_group->updated_at);

        $this->assertEquals($datetime->format($dateFormat->value), $additional_data_group->getUpdatedAt());
    }
}
