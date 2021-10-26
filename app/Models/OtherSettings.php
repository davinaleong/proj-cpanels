<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherSettings extends Model
{
    use HasFactory;

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

    public static function getKeys() {
        return OtherSettings::all()->pluck('key');
    }
}
