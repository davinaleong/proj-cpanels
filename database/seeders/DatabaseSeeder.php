<?php

namespace Database\Seeders;

use App\Models\OtherSettings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => env('ADMIN_NAME', 'admin'),
            'email' => env('ADMIN_EMAIL', 'John Doe'),
            'password' => Hash::make(env('ADMIN_PASSWORD', 'helloWorld')),
        ]);

        DB::table('other_settings')->insert([
            [
                'key' => OtherSettings::$KEY_DATETIME_FORMAT,
                'value' => 'd-m-Y H:i:s'
            ],
            [
                'key' => OtherSettings::$KEY_DB_DATETIME_FORMAT,
                'value' => 'Y-m-d H:i:s'
            ],
            [
                'key' => OtherSettings::$KEY_LIST_PER_PAGE,
                'value' => '50'
            ],
            [
                'key' => OtherSettings::$KEY_CARD_PER_PAGE,
                'value' => '24'
            ],
            [
                'key' => OtherSettings::$KEY_IMAGE_PLACEHOLDER,
                'value' => 'placeholder.png'
            ],
            [
                'key' => OtherSettings::$KEY_SEARCH_RESULTS_LIMIT,
                'value' => '10'
            ],
            [
                'key' => OtherSettings::$KEY_IMAGES_FOLDER,
                'value' => 'images'
            ]
        ]);
    }
}
