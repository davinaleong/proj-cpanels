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
            ->assertOk();
    }

    public function test_admin_can_create_a_project_type()
    {
        $user = User::factory()->create();
        $projectType = ProjectType::factory()->make();
        $activity = Activity::factory()->make([
            'log' => 'Created ' . $projectType->name . ' project type.',
            'link' => route('settings.project-types.edit', ['projectType' => 1]),
            'label' => 'View record'
        ]);

        $this->actingAs($user)
            ->post('/settings/project-types', [
                'name' => $projectType->name
            ])
            ->assertStatus(302)
            ->assertRedirect('/settings/project-types/')
            ->assertSessionHas('message', 'Project type created.');

        $this->assertDatabaseHas('project_types', [
            'name' => $projectType->name
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

    public function test_guest_gets_redirected_from_edit()
    {
        $projectType = ProjectType::factory()->create();

        $this->get('/settings/project-types/' . $projectType->id . '/edit')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_edit()
    {
        $user = User::factory()->create();
        $projectType = ProjectType::factory()->create();

        $this->actingAs($user)
            ->get('/settings/project-types/' . $projectType->id . '/edit')
            ->assertOk();
    }

    public function test_accessing_non_existent_project_type_returns_404()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/settings/project-types/1/edit')
            ->assertStatus(404);
    }

    public function test_admin_can_update_a_project_type()
    {
        $user = User::factory()->create();
        $projectType = ProjectType::factory()->create();
        $editedProjectType = ProjectType::factory()->make();
        $activity = Activity::factory()->make([
            'log' => 'Modified ' . $editedProjectType->name . ' project type.',
            'link' => route('settings.project-types.index'),
            'label' => 'View record'
        ]);

        $this->actingAs($user)
            ->patch('/settings/project-types/' . $projectType->id, [
                'name' => $editedProjectType->name
            ])
            ->assertRedirect('/settings/project-types')
            ->assertSessionHas('message', 'Project type modified.');

        $this->assertDatabaseHas('project_types', [
            'id' => $projectType->id,
            'name' => $editedProjectType->name
        ]);
        $this->assertDatabaseHas('activities', [
            'log' => $activity->log,
            'link' => $activity->link,
            'label' => $activity->label
        ]);
    }

    public function test_update_project_type_validation()
    {
        $user = User::factory()->create();
        $projectType = ProjectType::factory()->create();

        $this->actingAs($user)
            ->patch('settings/project-types/' . $projectType->id, [
                'name' => ''
            ])
            ->assertSessionHasErrors(['name']);

        $this->actingAs($user)
            ->patch('settings/project-types/' . $projectType->id, [
                'name' => Str::random(256)
            ])
            ->assertSessionHasErrors(['name']);
    }

    public function test_admin_can_delete_a_project_type()
    {
        $user = User::factory()->create();
        $projectType = ProjectType::factory()->create();
        $activity = Activity::factory()->make([
            'log' => 'Deleted ' . $projectType->name . ' project type.'
        ]);

        $this->actingAs($user)
            ->delete('/settings/project-types/' . $projectType->id)
            ->assertStatus(302)
            ->assertRedirect('/settings/project-types')
            ->assertSessionHas('message', 'Project type deleted.');

        $this->assertSoftDeleted('project_types', [
            'id' => $projectType->id
        ]);
        $this->assertDatabaseHas('activities', [
            'log' => $activity->log
        ]);
    }
}
