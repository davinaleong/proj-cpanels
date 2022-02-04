<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class BlankTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_gets_redirected()
    {
        $this->get('/blank')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_user_can_access_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/blank')
            ->assertOk();
    }
}
