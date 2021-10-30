<?php

namespace Tests\Feature\Settings;

use App\Models\Activity;
use App\Models\Image;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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

    public function test_guest_gets_redirected_from_create()
    {
        $this->get('/settings/images/create')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_create()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/settings/images/create')
            ->assertOk();
    }

    /** @group new */
    public function test_admin_can_create_an_image()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $image = Image::factory()->make([
            'filename' => 'hello world.jpg'
        ]);
        $activity = Activity::factory()->make([
            'log' => 'Created ' . $image->name . ' image.',
            'link' => route('settings.images.edit', ['image' => 1]),
            'label' => 'View record'
        ]);

        $this->actingAs($user)
            ->post('/settings/images', [
                'name' => $image->name,
                'folder_id' => $image->folder->id,
                'file' => UploadedFile::fake()->image($image->filename)
            ])
            ->assertStatus(302)
            ->assertRedirect('/settings/images/')
            ->assertSessionHas('message', 'Image created.');

        Storage::disk('public')->assertExists(Image::$FOLDER . $image->getFolderName() . now()->format('YmdHis') . '-' . urlencode($image->filename));

        $this->assertDatabaseHas('images', [
            'folder_id' => $image->folder_id,
            'name' => $image->name,
            'filename' => now()->format('YmdHis') . '-' . urlencode($image->filename)
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
            ->post('/settings/images', [
                'name' => '',
                'folder_id' => '',
                'file' => ''
            ])
            ->assertSessionHasErrors([
                'name',
                'folder_id',
                'file'
            ]);

        $this->actingAs($user)
            ->post('/settings/images', [
                'name' => Str::random(256),
                'folder_id' => 1,
                'file' => UploadedFile::fake()->create('document.pdf', 100)
            ])
            ->assertSessionHasErrors([
                'name',
                'folder_id',
                'file'
            ]);
    }
}
