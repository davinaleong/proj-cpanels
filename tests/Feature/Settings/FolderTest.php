<?php

namespace Tests\Feature\Settings;

use App\Models\Activity;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class FolderTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_gets_redirected_from_index()
    {
        $this->get('/settings/folders')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_index()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/settings/folders')
            ->assertOk();
    }

    public function test_guest_gets_redirected_from_create()
    {
        $this->get('/settings/folders/create')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_create()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/settings/folders/create')
            ->assertOk();
    }

    public function test_admin_can_create_a_folder()
    {
        $user = User::factory()->create();
        $folder = Folder::factory()->make();
        $activity = Activity::factory()->make([
            'log' => 'Created ' . $folder->name . ' folder.',
            'link' => route('settings.folders.edit', ['folder' => 1]),
            'label' => 'View record'
        ]);

        $this->actingAs($user)
            ->post('/settings/folders', [
                'name' => $folder->name
            ])
            ->assertStatus(302)
            ->assertRedirect('/settings/folders/')
            ->assertSessionHas('message', 'Folder created.');

        $this->assertDatabaseHas('folders', [
            'name' => $folder->name
        ]);
        $this->assertDatabaseHas('activities', [
            'log' => $activity->log,
            'link' => $activity->link,
            'label' => $activity->label
        ]);
    }

    public function test_create_validation_errors()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->post('/settings/folders', [
                'name' => ''
            ])
            ->assertSessionHasErrors(['name']);

        $this->actingAs($user)
            ->post('/settings/folders', [
                'name' => Str::random(256)
            ])
            ->assertSessionHasErrors(['name']);
    }

    /** @group new */
    public function test_guest_gets_redirected_from_edit()
    {
        $folder = Folder::factory()->create();

        $this->get('/settings/folders/' . $folder->id . '/edit')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @group new */
    public function test_admin_can_access_edit()
    {
        $user = User::factory()->create();
        $folder = Folder::factory()->create();

        $this->actingAs($user)
            ->get('/settings/folders/' . $folder->id . '/edit')
            ->assertOk();
    }

    /** @group new */
    public function test_accessing_non_existent_folder_returns_404()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/settings/folders/1/edit')
            ->assertStatus(404);
    }
}
