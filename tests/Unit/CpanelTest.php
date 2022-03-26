<?php

namespace Tests\Unit;

use App\Models\OtherSettings;
use App\Models\Cpanel;
use App\Models\Image;
use App\Models\ProjectType;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CpanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_a_project_type()
    {
        $cpanel = Cpanel::factory()->create();

        $this->assertInstanceOf(ProjectType::class, $cpanel->projectType);
    }

    public function test_has_an_image()
    {
        $cpanel = Cpanel::factory()->create();

        $this->assertInstanceOf(Image::class, $cpanel->image);
    }

    public function test_can_get_project_type_name()
    {
        $cpanel = Cpanel::factory()->create();

        $this->assertEquals($cpanel->projectType->name, $cpanel->getProjectTypeName());
    }

    public function test_can_get_image_url()
    {
        $image = Image::factory()
            ->create([
                'filename' => 'test.png'
            ]);

        $filepath = Image::getParentFolder() . $image->folder->name . '/' . $image->filename;
        $cpanel = Cpanel::factory()
            ->for($image)
            ->create();

        $expected_url = asset($filepath);
        if (env('FILESYSTEM_DRIVER') == 's3') {
            $expected_url = 'https://' . env('AWS_BUCKET', 'davina-cpanels') . '.s3.' . env('AWS_DEFAULT_REGION', 'ap-southeast-1') . '.amazonaws.com/' . $filepath;
        }

        $this->assertEquals($expected_url, $cpanel->getImage());
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

        $cpanel = Cpanel::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $cpanel->created_at);

        $this->assertEquals($datetime->format($dateFormat->value), $cpanel->getCreatedAt());
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

        $cpanel = Cpanel::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $cpanel->updated_at);

        $this->assertEquals($datetime->format($dateFormat->value), $cpanel->getUpdatedAt());
    }
}
