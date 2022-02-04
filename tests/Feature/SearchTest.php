<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_make_search_request()
    {
        $search_term = 'Site';
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/search', [
                'term' => $search_term
            ])
            ->assertStatus(302)
            ->assertRedirect('/search/results?term=' . $search_term);
    }

    public function test_guest_gets_redirected_from_results()
    {
        $search_term = 'Site';

        $this->get('/search/results?term=' . $search_term)
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_results()
    {
        $search_term = 'Site';
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/search/results?term=' . $search_term)
            ->assertOk(302);
    }
}
