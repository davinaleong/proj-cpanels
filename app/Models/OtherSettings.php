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
}
