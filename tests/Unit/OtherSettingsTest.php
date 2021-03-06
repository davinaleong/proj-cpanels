<?php

namespace Tests\Unit;

use App\Models\OtherSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OtherSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_static_keys()
    {
        $expected = [
            OtherSettings::$KEY_DATETIME_FORMAT,
            OtherSettings::$KEY_DB_DATETIME_FORMAT,
            OtherSettings::$KEY_LIST_PER_PAGE,
            OtherSettings::$KEY_CARD_PER_PAGE,
            OtherSettings::$KEY_IMAGE_PLACEHOLDER,
            OtherSettings::$KEY_SEARCH_RESULTS_LIMIT,
            OtherSettings::$KEY_IMAGES_FOLDER,
            OtherSettings::$KEY_FILESYSTEM_DRIVER,
        ];
        $this->assertEquals($expected, OtherSettings::getStaticKeys());
    }

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

    public function test_can_get_default_list_per_page()
    {
        $this->assertEquals(env('LIST_PER_PAGE'), OtherSettings::getListPerPage());
    }

    public function test_can_get_list_per_page()
    {
        $expected = OtherSettings::factory()->create([
            'key' => OtherSettings::$KEY_LIST_PER_PAGE,
            'value' => 'd M Y H:i:s'
        ]);

        $this->assertEquals($expected->value, OtherSettings::getListPerPage());
    }

    public function test_can_get_default_card_per_page()
    {
        $this->assertEquals(env('CARD_PER_PAGE'), OtherSettings::getCardPerPage());
    }

    public function test_can_get_card_per_page()
    {
        $expected = OtherSettings::factory()->create([
            'key' => OtherSettings::$KEY_CARD_PER_PAGE,
            'value' => 'd M Y H:i:s'
        ]);

        $this->assertEquals($expected->value, OtherSettings::getCardPerPage());
    }

    public function test_can_get_default_image_placeholder()
    {
        $this->assertEquals(env('IMAGE_PLACEHOLDER'), OtherSettings::getImagePlaceholder());
    }

    public function test_can_get_image_placeholder()
    {
        $expected = OtherSettings::factory()->create([
            'key' => OtherSettings::$KEY_IMAGE_PLACEHOLDER,
            'value' => 'images/placeholder.png'
        ]);

        $this->assertEquals($expected->value, OtherSettings::getImagePlaceholder());
    }

    public function test_can_get_search_results_limit()
    {
        $expected = OtherSettings::factory()->create([
            'key' => OtherSettings::$KEY_SEARCH_RESULTS_LIMIT,
            'value' => 10
        ]);

        $this->assertEquals($expected->value, OtherSettings::getSearchResultsLimit());
    }

    public function test_can_get_images_folder()
    {
        $expected = OtherSettings::factory()->create([
            'key' => OtherSettings::$KEY_IMAGES_FOLDER,
            'value' => 10
        ]);

        $this->assertEquals($expected->value, OtherSettings::getImagesFolder());
    }

    public function test_can_get_filesystem_driver()
    {
        $expected = OtherSettings::factory()->create([
            'key' => OtherSettings::$KEY_FILESYSTEM_DRIVER,
            'value' => 10
        ]);

        $this->assertEquals($expected->value, OtherSettings::getFilesystemDriver());
    }
}
