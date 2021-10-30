<?php

namespace Tests\Feature\Settings;

use App\Models\Activity;
use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_gets_redirected_from_index()
    {
        $this->get('/settings/images')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_index()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/settings/images')
            ->assertOk();
    }

    /** @group new */
    public function test_guest_gets_redirected_from_create()
    {
        $this->get('/settings/images/create')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @group new */
    public function test_admin_can_access_create()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/settings/images/create')
            ->assertOk();
    }
}
