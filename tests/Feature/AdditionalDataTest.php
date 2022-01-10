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
            'link' => route('additionalDataGroup.index'),
            'label' => 'View record'
        ]);

        $keys = [];
        $values = [];
        foreach($manyAdditionalData as $additionalData) {
            $keys[] = $additionalData->key;
            $values[] = $additionalData->value;
        }

        $this->actingAs($user)
            ->post('/additionalDataGroup', [
                'name' => $additionalDataGroup->name,
                'keys' => $keys,
                'values' => $values
            ])
            ->assertStatus(302)
            ->assertRedirect('/additionalDataGroup')
            ->assertSessionHas('message', 'Additional Data created.');

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
            ->post('/additionalDataGroup', [
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
            ->post('/additionalDataGroup', [
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

    public function test_guest_gets_redirected_from_edit()
    {
        $additionalDataGroup = AdditionalDataGroup::factory()->create();

        $this->get('/additionalDataGroup/' . $additionalDataGroup->id . '/edit')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_admin_can_access_edit()
    {
        $user = User::factory()->create();
        $additionalDataGroup = AdditionalDataGroup::factory()->create();

        $this->actingAs($user)
            ->get('/additionalDataGroup/' . $additionalDataGroup->id . '/edit')
            ->assertOk();
    }

    public function test_admin_can_update_an_additional_data_group()
    {
        $user = User::factory()->create();
        $additionalDataGroup = AdditionalDataGroup::factory()
            ->has(AdditionalData::factory()->count(2))
            ->create();
        $editAdditionalDataGroup = AdditionalDataGroup::factory()
            ->make();
        $editAdditionalDataCount = 3;
        $editManyAdditionalData = AdditionalData::factory()
            ->count($editAdditionalDataCount)
            ->make();
        $activity = Activity::factory()->make([
                'log' => 'Updated ' . $editAdditionalDataGroup->name . ' additional data group.',
                'link' => route('additionalDataGroup.index'),
                'label' => 'View record'
            ]);

        $keys = [];
        $values = [];
        foreach($editManyAdditionalData as $additionalData) {
            $keys[] = $additionalData->key;
            $values[] = $additionalData->value;
        }

        $this->actingAs($user)
            ->patch('/additionalDataGroup/' . $additionalDataGroup->id, [
                'name' => $editAdditionalDataGroup->name,
                'keys' => $keys,
                'values' => $values
            ])
            ->assertStatus(302)
            ->assertRedirect('/additionalDataGroup')
            ->assertSessionHas('message', 'Additional Data updated.');

        $this->assertDatabaseHas('additional_data_groups', [
            'id' => $additionalDataGroup->id,
            'name' => $editAdditionalDataGroup->name
        ]);

        $this->assertEquals($editAdditionalDataCount, $additionalDataGroup->fresh()->additionalData->count());

        $this->assertDatabaseHas('activities', [
            'log' => $activity->log,
            'link' => $activity->link,
            'label' => $activity->label
        ]);
    }

    public function test_update_additional_data_group_validation()
    {
        $user = User::factory()->create();
        $additionalDataGroup = AdditionalDataGroup::factory()->create();

        $this->actingAs($user)
            ->patch('/additionalDataGroup/' . $additionalDataGroup->id, [
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
            ->patch('/additionalDataGroup/' . $additionalDataGroup->id, [
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

    public function test_admin_can_delete_an_additional_data_group()
    {
        $user = User::factory()->create();
        $additionalDataGroup = AdditionalDataGroup::factory()
            ->has(AdditionalData::factory()->count(2))
            ->create();
        $activity = Activity::factory()->make([
            'log' => 'Deleted ' . $additionalDataGroup->name . ' additional data.'
        ]);
        $manyAdditionalData = $additionalDataGroup->additionalData;

        $this->actingAs($user)
            ->delete('/additionalDataGroup/' . $additionalDataGroup->id)
            ->assertRedirect('/additionalDataGroup')
            ->assertSessionHas('message', 'Additional Data deleted.');

        $this->assertSoftDeleted('additional_data_groups', [
            'id' => $additionalDataGroup->id
        ]);

        foreach($manyAdditionalData as $additionalData) {
            $this->assertSoftDeleted('additional_data', [
                'id' => $additionalData->id
            ]);
        }

        $this->assertDatabaseHas('activities', [
            'log' => $activity->log
        ]);
    }
}
