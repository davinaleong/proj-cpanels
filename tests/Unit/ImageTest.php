<?php

namespace Tests\Unit;

use App\Models\Folder;
use App\Models\Image;
use App\Models\OtherSettings;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_folder()
    {
        $image = Image::factory()->create();

        $this->assertInstanceOf(Folder::class, $image->folder);
    }

    public function test_can_get_folder_name()
    {
        $image = Image::factory()->create();

        $this->assertEquals($image->folder->name . '/', $image->getFolderName());
    }

    /** @group new */
    public function test_can_get_placeholder_image()
    {
        $image = Image::factory()->create();

        $this->assertEquals(asset(env('IMAGE_PLACEHOLDER')), $image->getFile());
    }

    /** @group new */
    public function test_can_get_file()
    {
        $folder = Folder::factory()->create([
            'name' => 'test'
        ]);
        $image = Image::factory()
            ->for($folder)
            ->create([
                'folder_id' => $folder->id,
                'filename' => 'test.png'
            ]);

        $filepath = 'images/' . $folder->name . '/' . $image->filename;

        $this->assertEquals(asset($filepath), $image->getFile());
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
