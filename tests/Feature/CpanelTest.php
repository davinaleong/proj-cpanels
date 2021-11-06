<?php

namespace Tests\Feature;

use App\Models\Cpanel;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CpanelTest extends TestCase
{
    use RefreshDatabase;

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

    /** @group new */
    public function test_guest_gets_redirected_from_create()
    {
        $this->get('/cpanels/create')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @group new */
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
}
