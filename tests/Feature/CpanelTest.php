<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Cpanel;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class CpanelTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_guest_gets_redirected_from_index()
    {
        $this->get('/cpanels')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_index()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/cpanels')
            ->assertOk();
    }

    public function test_guest_gets_redirected_from_create()
    {
        $this->get('/cpanels/create')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_create()
    {
        Folder::factory()
            ->create([
                'name' => Cpanel::$SUB_FOLDER
            ]);
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/cpanels/create')
            ->assertOk();
    }

    public function test_admin_can_create_a_cpanel()
    {
        $user = User::factory()->create();
        $cpanel = Cpanel::factory()->make();
        $activity = Activity::factory()->make([
            'log' => 'Created ' . $cpanel->name . ' cpanel.',
            'link' => route('cpanels.show', ['cpanel' => 1]),
            'label' => 'View record'
        ]);

        $this->actingAs($user)
            ->post('cpanels', [
                'name' => $cpanel->name,
                'project_type_id' => $cpanel->project_type_id,
                'image_id' => $cpanel->image_id
            ])
            ->assertStatus(302)
            ->assertSessionHas('message', 'CPanel created.')
            ->assertRedirect('/cpanels/1');

        $this->assertDatabaseHas('cpanels', [
            'name' => $cpanel->name,
            'image_id' => $cpanel->image_id,
            'project_type_id' => $cpanel->project_type_id
        ]);

        $this->assertDatabaseHas('activities', [
            'log' => $activity->log,
            'link' => $activity->link,
            'label' => $activity->label
        ]);
    }

    public function test_create_cpanel_validation()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('cpanels', [
                'name' => '',
                'project_type_id' => '',
                'image_id' => ''
            ])
            ->assertSessionHasErrors([
                'name',
                'project_type_id',
                'image_id'
            ]);

        $this->actingAs($user)
            ->post('cpanels', [
                'name' => Str::random(256),
                'project_type_id' => 'project',
                'image_id' => 'image'
            ])
            ->assertSessionHasErrors([
                'name',
                'project_type_id',
                'image_id'
            ]);

        $this->actingAs($user)
            ->post('cpanels', [
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
        $cpanel = Cpanel::factory()->create();

        $this->get('/cpanels/' . $cpanel->id)
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_show()
    {
        $user = User::factory()->create();
        $cpanel = Cpanel::factory()->create();

        $this->actingAs($user)
            ->get('/cpanels/' . $cpanel->id)
            ->assertOk();
    }
}
