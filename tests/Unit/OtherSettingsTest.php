<?php

namespace Tests\Unit;

use App\Models\OtherSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OtherSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_other_settings_by_key()
    {
        $expected = OtherSettings::factory()->create([
            'key' => 'Key',
            'value' => 'Value'
        ]);

        $actual = OtherSettings::getByKey($expected->key);

        $this->assertEquals($expected->value, $actual->value);
    }

    public function test_can_get_keys()
    {
        $otherSettings = OtherSettings::factory()
            ->count(2)
            ->create();

        $expected = [];
        foreach ($otherSettings as $otherSetting) {
            $expected[] = $otherSetting->key;
        }

        $actual = OtherSettings::getKeys();

        $this->assertEquals($expected, $actual->toArray());
    }

    public function test_can_get_default_date_format()
    {
        $this->assertEquals(env('DEFAULT_DT_FORMAT'), OtherSettings::getDatetimeFormat());
    }

    public function test_can_get_date_format()
    {
        $expected = OtherSettings::factory()->create([
            'key' => OtherSettings::$KEY_DATETIME_FORMAT,
            'value' => 'd M Y H:i:s'
        ]);

        $this->assertEquals($expected->value, OtherSettings::getDatetimeFormat());
    }

    public function test_can_get_default_db_date_format()
    {
        $this->assertEquals(env('DB_DT_FORMAT'), OtherSettings::getDbDatetimeFormat());
    }

    public function test_can_get_db_date_format()
    {
        $expected = OtherSettings::factory()->create([
            'key' => OtherSettings::$KEY_DB_DATETIME_FORMAT,
            'value' => 'd M Y H:i:s'
        ]);

        $this->assertEquals($expected->value, OtherSettings::getDbDatetimeFormat());
    }

    /** @group new */
    public function test_can_get_default_list_per_page()
    {
        $this->assertEquals(env('LIST_PER_PAGE'), OtherSettings::getListPerPage());
    }

    /** @group new */
    public function test_can_get_list_per_page()
    {
        $expected = OtherSettings::factory()->create([
            'key' => OtherSettings::$KEY_LIST_PER_PAGE,
            'value' => 'd M Y H:i:s'
        ]);

        $this->assertEquals($expected->value, OtherSettings::getListPerPage());
    }

    /** @group new */
    public function test_can_get_default_card_per_page()
    {
        $this->assertEquals(env('CARD_PER_PAGE'), OtherSettings::getCardPerPage());
    }

    /** @group new */
    public function test_can_get_card_per_page()
    {
        $expected = OtherSettings::factory()->create([
            'key' => OtherSettings::$KEY_CARD_PER_PAGE,
            'value' => 'd M Y H:i:s'
        ]);

        $this->assertEquals($expected->value, OtherSettings::getCardPerPage());
    }
}
