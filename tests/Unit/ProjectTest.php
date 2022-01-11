<?php

namespace Tests\Unit;

use App\Models\OtherSettings;
use App\Models\Project;
use App\Models\Image;
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

        $filepath = Image::$FOLDER . $image->folder->name . '/' . $image->filename;
        $project = Project::factory()
            ->for($image)
            ->create();

        $this->assertEquals(asset($filepath), $project->getImage());
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
