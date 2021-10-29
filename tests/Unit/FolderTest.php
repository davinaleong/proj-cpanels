<?php

namespace Tests\Unit;

use App\Models\Folder;
use App\Models\OtherSettings;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FolderTest extends TestCase
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

        $folder = Folder::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $folder->created_at);

        $this->assertEquals($datetime->format($dateFormat->value), $folder->getCreatedAt());
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

        $folder = Folder::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $folder->updated_at);

        $this->assertEquals($datetime->format($dateFormat->value), $folder->getUpdatedAt());
    }
}
