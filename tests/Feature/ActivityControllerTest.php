<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_gets_redirected()
    {
        $this->get('/dashboard')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk();
    }
}
