<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultCredential extends Model
{
    public static function getOc()
    {
        return [
            'username' => env('DEFAULT_BACKEND_USERNAME_OC'),
            'password' => env('DEFAULT_BACKEND_PASSWORD_OC')
        ];
    }

    public static function getWp()
    {
        return [
            'username' => env('DEFAULT_BACKEND_USERNAME_WP'),
            'password' => env('DEFAULT_BACKEND_PASSWORD_WP')
        ];
    }
}
