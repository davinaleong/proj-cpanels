<?php

namespace Tests\Unit;

use App\Models\DemoCpanel;
use App\Models\OtherSettings;
use App\Models\Project;
use App\Models\Image;
use App\Models\LiveCpanel;
use App\Models\ProjectType;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_a_project_type()
    {
        $project = Project::factory()->create();

        $this->assertInstanceOf(ProjectType::class, $project->projectType);
    }

    public function test_has_an_image()
    {
        $project = Project::factory()->create();

        $this->assertInstanceOf(Image::class, $project->image);
    }

    public function test_has_a_demo_cpanel()
    {
        $project = Project::factory()
            ->has(DemoCpanel::factory()->count(1))
            ->create();

        $this->assertInstanceOf(DemoCpanel::class, $project->demoCpanel);
    }

    public function test_has_a_live_cpanel()
    {
        $project = Project::factory()
            ->has(LiveCpanel::factory()->count(1))
            ->create();

        $this->assertInstanceOf(LiveCpanel::class, $project->liveCpanel);
    }

    public function test_can_get_project_type_name()
    {
        $project = Project::factory()->create();

        $this->assertEquals($project->projectType->name, $project->getProjectTypeName());
    }

    public function test_can_get_image_url()
    {
        $image = Image::factory()
            ->create([
                'filename' => 'test.png'
            ]);

        $filepath = Image::getParentFolder() . $image->folder->name . '/' . $image->filename;
        $project = Project::factory()
            ->for($image)
            ->create();

        $expected_url = asset($filepath);
        if (env('FILESYSTEM_DRIVER') == 's3') {
            $expected_url = 'https://' . env('AWS_BUCKET', 'davina-cpanels') . '.s3.' . env('AWS_DEFAULT_REGION', 'ap-southeast-1') . '.amazonaws.com/' . $filepath;
        }

        $this->assertEquals($expected_url, $project->getImage());
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

        $project = Project::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $project->created_at);

        $this->assertEquals($datetime->format($dateFormat->value), $project->getCreatedAt());
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

        $project = Project::factory()->create();
        $datetime = Carbon::createFromFormat($dbDateFormat->value, $project->updated_at);

        $this->assertEquals($datetime->format($dateFormat->value), $project->getUpdatedAt());
    }
}
