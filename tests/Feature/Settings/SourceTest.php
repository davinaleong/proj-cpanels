<?php

namespace Tests\Feature\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_gets_redirected()
    {
        $this->get('/settings/sources')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_index()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/settings/sources')
            ->assertOk();
    }
}
