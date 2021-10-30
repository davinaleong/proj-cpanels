<?php

namespace Tests\Unit;

use App\Models\Image;
use App\Models\OtherSettings;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImageTest extends TestCase
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

        $image = Image::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $image->created_at);

        $this->assertEquals($datetime->format($dateFormat->value), $image->getCreatedAt());
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

        $image = Image::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $image->updated_at);

        $this->assertEquals($datetime->format($dateFormat->value), $image->getUpdatedAt());
    }
}
