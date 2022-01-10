<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\AdditionalData;
use App\Models\AdditionalDataGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdditionalDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_gets_redirected_from_index()
    {
        $this->get('/additionalDataGroup')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_index()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/additionalDataGroup')
            ->assertOk();
    }

    public function test_guest_gets_redirected_from_create()
    {
        $this->get('/additionalDataGroup/create')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_create()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/additionalDataGroup/create')
            ->assertOk();
    }

    public function test_admin_can_create_an_additional_data_group()
    {
        $user = User::factory()->create();
        $additionalDataCount = 2;
        $additionalDataGroup = AdditionalDataGroup::factory()->make();
        $manyAdditionalData = AdditionalData::factory()
            ->count($additionalDataCount)
            ->make();
        $activity = Activity::factory()->make([
            'log' => 'Created ' . $additionalDataGroup->name . ' additional data group.',
            'link' => route('additionalData.index'),
            'label' => 'View record'
        ]);

        $keys = [];
        $values = [];
        foreach($manyAdditionalData as $additionalData) {
            $keys[] = $additionalData->key;
            $values[] = $additionalData->value;
        }

        $this->actingAs($user)
            ->post('additionalData', [
                'name' => $additionalDataGroup->name,
                'keys' => $keys,
                'values' => $values
            ])
            ->assertStatus(302)
            ->assertSessionHas('message', 'Additional Data Group created.')
            ->assertRedirect('/additionalDataGroup');

        $this->assertDatabaseHas('additional_data_groups', [
            'name' => $additionalDataGroup->name
        ]);

        $lastAdditionalDataGroup = AdditionalDataGroup::orderByDesc('id')
            ->first();
        $this->assertEquals($additionalDataCount, $lastAdditionalDataGroup->additionalData->count());

        $this->assertDatabaseHas('activities', [
            'log' => $activity->log,
            'link' => $activity->link,
            'label' => $activity->label
        ]);
    }

    public function test_create_additional_data_validation()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('additionalData', [
                'name' => '',
                'keys' => '',
                'values' => ''
            ])
            ->assertSessionHasErrors([
                'name',
                'keys',
                'values'
            ]);

        $this->actingAs($user)
            ->post('additionalData', [
                'name' => '',
                'keys' => 'Hello',
                'values' => 'Hello'
            ])
            ->assertSessionHasErrors([
                'name',
                'keys',
                'values'
            ]);
    }
}
