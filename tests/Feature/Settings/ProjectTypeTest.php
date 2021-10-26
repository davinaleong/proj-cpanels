<?php

namespace Tests\Feature\Settings;

use App\Models\Activity;
use App\Models\ProjectType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProjectTypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_gets_redirected_from_index()
    {
        $this->get('/settings/project-types')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_index()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/settings/project-types')
            ->assertOk();
    }

    public function test_guest_gets_redirected_from_create()
    {
        $this->get('/settings/project-types/create')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_create()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/settings/project-types/create')
            ->assertSessionHas('message', 'New project type created.')
            ->assertOk();
    }

    public function test_admin_can_create_a_project_type()
    {
        $user = User::factory()->create();
        $project_type = ProjectType::factory()->make();
        $activity = Activity::factory()->make([
            'log' => 'New project type created.',
            'link' => route('settings.project-types.edit', ['projectType' => 1]),
            'label' => 'View record'
        ]);

        $this->actingAs($user)
            ->post('/settings/project-types', [
                'name' => $project_type->name
            ])
            ->assertStatus(302)
            ->assertRedirect('/settings/project-types/1/edit');

        $this->assertDatabaseHas('project_types', [
            'name' => $project_type->name
        ]);
        $this->assertDatabaseHas('activities', [
            'log' => $activity->log,
            'link' => $activity->link,
            'label' => $activity->label
        ]);
    }

    public function test_create_validation_errors()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->post('/settings/project-types', [
                'name' => ''
            ])
            ->assertSessionHasErrors(['name']);

        $this->actingAs($user)
            ->post('/settings/project-types', [
                'name' => Str::random(256)
            ])
            ->assertSessionHasErrors(['name']);
    }
}
