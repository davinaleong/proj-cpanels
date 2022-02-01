<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Project;
use App\Models\DemoCpanel;
use App\Models\LiveCpanel;
use App\Models\Folder;
use App\Models\User;use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

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

    /** @group new */
    public function test_guest_gets_redirected_from_create()
    {
        $this->get('/projects/create')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @group new */
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
}
