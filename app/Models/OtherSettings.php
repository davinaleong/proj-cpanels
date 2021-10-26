<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherSettings extends Model
{
    use HasFactory;

    public static $KEY_DATETIME_FORMAT = 'Datetime Format';
    public static $KEY_DB_DATETIME_FORMAT = 'DB Datetime Format';

    protected $table = 'other_settings';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public static function getByKey(string $key)
    {
        return OtherSettings::where('key', $key)
            ->first();
    }

    public static function getKeys()
    {
        return OtherSettings::all()->pluck('key');
    }

    public static function getDatetimeFormat()
    {
        $datetime_format = env('DEFAULT_DT_FORMAT');
        $dtOtherSettings = OtherSettings::getByKey(OtherSettings::$KEY_DATETIME_FORMAT);

        if (filled($dtOtherSettings)) {
            $datetime_format = $dtOtherSettings->value;
        }

        return $datetime_format;
    }

    public static function getDbDatetimeFormat()
    {
        $datetime_format = env('DB_DT_FORMAT');
        $dtOtherSettings = OtherSettings::getByKey(OtherSettings::$KEY_DB_DATETIME_FORMAT);

        if (filled($dtOtherSettings)) {
            $datetime_format = $dtOtherSettings->value;
        }

        return $datetime_format;
    }
}
