<?php

namespace Tests\Feature\Settings;

use App\Models\Activity;
use App\Models\Folder;
use App\Models\Image;
use App\Models\User;
use App\Models\OtherSettings;
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
    use WithFaker;

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

    public function test_admin_can_create_an_image()
    {
        Storage::fake(OtherSettings::getFilesystemDriver());

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

        $filename = now()->format('YmdHis') . '-' . urlencode(Str::snake($image->filename));
        Storage::disk(OtherSettings::getFilesystemDriver())->assertExists(Image::getParentFolder() . $image->getFolderName() . $filename);

        $this->assertDatabaseHas('images', [
            'folder_id' => $image->folder_id,
            'name' => $image->name,
            'filename' => $filename
        ]);
        $this->assertDatabaseHas('activities', [
            'log' => $activity->log,
            'link' => $activity->link,
            'label' => $activity->label
        ]);
    }

    public function test_create_image_validation()
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

    public function test_guest_gets_redirected_from_edit()
    {
        $image = Image::factory()->create();

        $this->get('/settings/images/' . $image->id . '/edit')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_edit()
    {
        $user = User::factory()->create();
        $image = Image::factory()->create();

        $this->actingAs($user)
            ->get('/settings/images/' . $image->id . '/edit')
            ->assertOk();
    }

    public function test_accessing_non_existent_image_returns_404()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/settings/images/1/edit')
            ->assertStatus(404);
    }

    public function test_admin_can_update_an_image()
    {
        Storage::fake(OtherSettings::getFilesystemDriver());

        $user = User::factory()->create();

        $folder = Folder::factory()->create();
        $image = Image::factory()->create([
            'filename' => now()->format('YmdHis') . '-' . urlencode('hello world.png')
        ]);
        $editedImage = Image::factory()->make([
            'name' => 'New image',
            'filename' => 'hello earth.png'
        ]);
        $activity = Activity::factory()->make([
            'log' => 'Modified ' . $editedImage->name . ' image.',
            'link' => route('settings.images.edit', ['image' => $image]),
            'label' => 'View record'
        ]);

        Storage::disk(OtherSettings::getFilesystemDriver())->put(Image::getParentFolder() . $image->getFolderName() . $image->filename, $this->faker->image());
        Storage::disk(OtherSettings::getFilesystemDriver())->assertExists(Image::getParentFolder() . $image->getFolderName() . $image->filename);

        $this->actingAs($user)
            ->patch('/settings/images/' . $folder->id, [
                'name' => $editedImage->name,
                'file' => UploadedFile::fake()->image($editedImage->filename)
            ])
            ->assertStatus(302)
            ->assertRedirect('/settings/images')
            ->assertSessionHas('message', 'Image modified.');

        $updated_filename = now()->format('YmdHis') . '-' . urlencode(Str::snake($editedImage->filename));
        Storage::disk(OtherSettings::getFilesystemDriver())->assertMissing(Image::getParentFolder() . $image->getFolderName() . $image->filename);
        Storage::disk(OtherSettings::getFilesystemDriver())->assertExists(Image::getParentFolder() . $image->getFolderName() . $updated_filename);

        $this->assertDatabaseHas('images', [
            'id' => $folder->id,
            'name' => $editedImage->name,
            'filename' => $updated_filename
        ]);
        $this->assertDatabaseHas('activities', [
            'log' => $activity->log,
            'link' => $activity->link,
            'label' => $activity->label
        ]);
    }

    public function test_update_image_validation()
    {
        $user = User::factory()->create();
        $image = Image::factory()->create();

        $this->actingAs($user)
            ->patch('settings/images/' . $image->id, [
                'name' => ''
            ])
            ->assertSessionHasErrors([
                'name'
            ]);

        $this->actingAs($user)
            ->patch('settings/images/' . $image->id, [
                'name' => Str::random(256),
                'file' => UploadedFile::fake()->create('document.pdf', 100)
            ])
            ->assertSessionHasErrors([
                'name',
                'file'
            ]);
    }

    public function test_admin_can_delete_an_image()
    {
        Storage::fake(OtherSettings::getFilesystemDriver());

        $user = User::factory()->create();
        $image = Image::factory()->create();
        $activity = Activity::factory()->make([
            'log' => 'Deleted ' . $image->name . ' image.'
        ]);

        $filepath = Image::getParentFolder() . $image->getFolderName() . $image->filename;
        Storage::disk(OtherSettings::getFilesystemDriver())->put($filepath, $this->faker->image());
        Storage::disk(OtherSettings::getFilesystemDriver())->assertExists($filepath);

        $this->actingAs($user)
            ->delete('/settings/images/' . $image->id)
            ->assertStatus(302)
            ->assertRedirect('/settings/images')
            ->assertSessionHas('message', 'Image deleted.');

        Storage::disk(OtherSettings::getFilesystemDriver())->assertMissing($filepath);

        $this->assertSoftDeleted('images', [
            'id' => $image->id
        ]);
        $this->assertDatabaseHas('activities', [
            'log' => $activity->log
        ]);
    }
}
