<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function folder()
    {
        return $this->belongsTo('App\Models\Folder');
    }

    public function getFolderName()
    {
        return filled($this->folder) ? $this->folder->name . '/' : '';
    }

    public function getFile()
    {
        $url = asset(OtherSettings::getImagePlaceholder());
        $filepath = 'images/' . $this->getFolderName() . $this->filename;

        if (filled($this->filename) && Storage::disk('public')->exists($filepath)) {
            $url = asset($filepath);
        }

        return $url;
    }

    public function getCreatedAt()
    {
        $dbDatetimeFormat = OtherSettings::getDbDatetimeFormat();

        if (filled($this->created_at)) {
            $datetimeFormat = OtherSettings::getDatetimeFormat();

            $dt = Carbon::createFromFormat($dbDatetimeFormat, $this->created_at);
            return $dt->format($datetimeFormat);
        } else {
            return '';
        }
    }

    public function getUpdatedAt()
    {
        $dbDatetimeFormat = OtherSettings::getDbDatetimeFormat();

        if (filled($this->updated_at)) {
            $datetimeFormat = OtherSettings::getDatetimeFormat();

            $dt = Carbon::createFromFormat($dbDatetimeFormat, $this->updated_at);
            return $dt->format($datetimeFormat);
        } else {
            return '';
        }
    }
}
