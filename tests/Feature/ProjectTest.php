<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Project;
use App\Models\DemoCpanel;
use App\Models\LiveCpanel;
use App\Models\Folder;
use App\Models\User;use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_guest_gets_redirected_from_index()
    {
        $this->get('/projects')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_index()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/projects')
            ->assertOk();
    }

    public function test_guest_gets_redirected_from_create()
    {
        $this->get('/projects/create')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_create()
    {
        Folder::factory()
            ->create([
                'name' => Project::$SUB_FOLDER
            ]);
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/projects/create')
            ->assertOk();
    }

    public function test_admin_can_create_a_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->make();
        $demo_cpanel = DemoCpanel::factory()->for($project)->make();
        $live_cpanel = LiveCpanel::factory()->for($project)->make();

        $activity = Activity::factory()->make([
            'log' => 'Created ' . $project->name . ' project.',
            'link' => route('projects.show', ['project' => 1]),
            'label' => 'View record'
        ]);

        $this->actingAs($user)
            ->post('projects', [
                'project_type_id' => $project->project_type_id,
                'image_id' => $project->image_id,
                'name' => $project->name,
                'project_executive' => $project->project_executive,
                'is_full_project' => $project->is_full_project ? 'yes': '',
                'notes' => $project->notes,
                'demo' => [
                    'site_url' => $demo_cpanel->site_url,
                    'admin_url' => $demo_cpanel->admin_url,
                    'cpanel_url' => $demo_cpanel->cpanel_url,
                    'design_url' => $demo_cpanel->design_url,
                    'programming_brief_url' => $demo_cpanel->programming_brief_url,

                    'cpanel_username' => $demo_cpanel->cpanel_username,
                    'cpanel_password' => $demo_cpanel->cpanel_password,

                    'db_username' => $demo_cpanel->db_username,
                    'db_password' => $demo_cpanel->db_password,
                    'db_name' => $demo_cpanel->db_name,

                    'backend_username' => $demo_cpanel->backend_username,
                    'backend_password' => $demo_cpanel->backend_password,

                    'started_at' => $demo_cpanel->started_at,
                    'ended_at' => $demo_cpanel->ended_at
                ],
                'live' => [
                    'site_url' => $live_cpanel->site_url,
                    'admin_url' => $live_cpanel->admin_url,
                    'cpanel_url' => $live_cpanel->cpanel_url,

                    'cpanel_username' => $live_cpanel->cpanel_username,
                    'cpanel_password' => $live_cpanel->cpanel_password,

                    'db_username' => $live_cpanel->db_username,
                    'db_password' => $live_cpanel->db_password,
                    'db_name' => $live_cpanel->db_name,

                    'admin_panel' => $live_cpanel->admin_panel,
                    'backend_username' => $live_cpanel->backend_username,
                    'backend_password' => $live_cpanel->backend_password,

                    'lived_at' => $live_cpanel->lived_at,
                ]
            ])
            ->assertStatus(302)
            ->assertSessionHas('message', 'Project created.')
            ->assertRedirect('/projects/1');

        $this->assertDatabaseHas('projects', [
            'id' => (string) 1,
            'name' => $project->name,
            'image_id' => (string) $project->image_id,
            'project_type_id' => (string) $project->project_type_id
        ]);

        $this->assertDatabaseHas('demo_cpanels', [
            'project_id' => (string) 1,
        ]);

        $this->assertDatabaseHas('live_cpanels', [
            'project_id' => (string) 1,
        ]);

        $this->assertDatabaseHas('activities', [
            'log' => $activity->log,
            'link' => $activity->link,
            'label' => $activity->label
        ]);
    }

    public function test_create_project_validation()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('projects', [
                'name' => '',
                'project_type_id' => '',
                'image_id' => '',
                'is_full_project' => ''
            ])
            ->assertSessionHasErrors([
                'name',
                'project_type_id',
                'image_id'
            ]);

        $this->actingAs($user)
            ->post('projects', [
                'name' => Str::random(256),
                'project_type_id' => 'project',
                'image_id' => 'image',
                'is_full_project' => 'hello'
            ])
            ->assertSessionHasErrors([
                'name',
                'project_type_id',
                'image_id',
                'is_full_project'
            ]);

        $this->actingAs($user)
            ->post('projects', [
                'name' => $this->faker->name,
                'project_type_id' => 99,
                'image_id' => 99
            ])
            ->assertSessionHasErrors([
                'project_type_id',
                'image_id'
            ]);
    }

    public function test_guest_gets_redirected_from_show()
    {
        $project = Project::factory()->create();

        $this->get('/projects/' . $project->id)
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_show()
    {
        $user = User::factory()->create();
        $project = Project::factory()
            ->has(DemoCpanel::factory()->count(1))
            ->has(LiveCpanel::factory()->count(1))
            ->create();

        $this->actingAs($user)
            ->get('/projects/' . $project->id)
            ->assertOk();
    }

    public function test_guest_gets_redirected_from_edit()
    {
        $project = Project::factory()
            ->has(DemoCpanel::factory()->count(1))
            ->has(LiveCpanel::factory()->count(1))
            ->create();

        $this->get('/projects/' . $project->id . '/edit')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_edit()
    {
        Folder::factory()
            ->create([
                'name' => Project::$SUB_FOLDER
            ]);
        $user = User::factory()->create();
        $project = Project::factory()
            ->has(DemoCpanel::factory()->count(1))
            ->has(LiveCpanel::factory()->count(1))
            ->create();

        $this->actingAs($user)
            ->get('/projects/' . $project->id . '/edit')
            ->assertOk();
    }
}
