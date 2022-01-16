<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @group new */
    public function test_guest_gets_redirected_from_index()
    {
        $this->get('/projects')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @group new */
    public function test_admin_can_access_index()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/projects')
            ->assertOk();
    }
}
