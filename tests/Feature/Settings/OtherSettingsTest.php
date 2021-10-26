<?php

namespace Tests\Feature\Settings;

use App\Models\Activity;
use App\Models\OtherSettings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OtherSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_gets_redirected_from_index()
    {
        $this->get('/settings/other-settings')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_index()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/settings/other-settings')
            ->assertOk();
    }

    public function test_guest_gets_redirected_from_edit()
    {
        $this->get('/settings/other-settings/edit')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_edit()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/settings/other-settings/edit')
            ->assertOk();
    }

    public function test_admin_can_edit_other_settings()
    {
        $user = User::factory()->create();
        $activity = Activity::factory()->make([
            'log' => 'Modified other settings.',
            'link' => route('settings.other-settings.index'),
            'label' => 'View records'
        ]);
        $otherSettings = OtherSettings::factory()->count(2)->make();

        $this->actingAs($user)
            ->post('/settings/other-settings/edit', [
                'otherSettings' => $otherSettings->toArray()
            ])
            ->assertRedirect('/settings/other-settings')
            ->assertSessionHas('message', 'Other Settings updated.');

        $this->assertDatabaseHas('other_settings', [
            'key' => $otherSettings[0]->key,
            'value' => $otherSettings[0]->value
        ]);
        $this->assertDatabaseHas('other_settings', [
            'key' => $otherSettings[1]->key,
            'value' => $otherSettings[1]->value
        ]);
        $this->assertDatabaseHas('activities', [
            'log' => $activity->log,
            'link' => $activity->link,
            'label' => $activity->label,
        ]);
    }

    public function test_edit_other_settings_validation() {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/settings/other-settings/edit', [
                'otherSettings' => []
            ])
            ->assertSessionHasErrors([
                'otherSettings'
            ]);

        $this->actingAs($user)
            ->post('/settings/other-settings/edit', [
                'otherSettings' => [
                    [
                        'key' => '',
                        'value' => ''
                    ]
                ]
            ])
            ->assertSessionHasErrors([
                'otherSettings.0.key',
                'otherSettings.0.value'
            ]);
    }
}
