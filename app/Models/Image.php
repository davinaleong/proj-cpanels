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

    public static function getParentFolder() {
        return OtherSettings::getImagesFolder() . '/';
    }

    public static function getPlaceholder() {
        $filepath = Image::getParentFolder() . OtherSettings::getImagePlaceholder();

        if (env('FILESYSTEM_DRIVER') == 's3') {
            return $url = 'https://' . env('AWS_BUCKET', 'davina-cpanels') . '.s3.' . env('AWS_DEFAULT_REGION', 'ap-southeast-1') . '.amazonaws.com/' . $filepath;
        }
        return asset($filepath);
    }

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
        $url = Image::getPlaceholder();
        $filepath = Image::getParentFolder() . $this->getFolderName() . $this->filename;

        if (filled($this->filename) && Storage::disk(OtherSettings::getFilesystemDriver())->exists($filepath)) {
            $url = asset($filepath);

            if (env('FILESYSTEM_DRIVER') == 's3') {
                $url = 'https://' . env('AWS_BUCKET', 'davina-cpanels') . '.s3.' . env('AWS_DEFAULT_REGION', 'ap-southeast-1') . '.amazonaws.com/' . $filepath;
            }
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
