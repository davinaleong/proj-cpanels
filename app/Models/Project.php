<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static $SUB_FOLDER = 'projects';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function projectType()
    {
        return $this->belongsTo('App\Models\ProjectType');
    }

    public function image()
    {
        return $this->belongsTo('App\Models\Image');
    }

    public function demoCpanel()
    {
        return $this->hasOne('App\Models\DemoCpanel');
    }

    public function liveCpanel()
    {
        return $this->hasOne('App\Models\LiveCpanel');
    }

    public function getProjectTypeName()
    {
        return $this->projectType ? $this->projectType->name : '';
    }

    public function getImage()
    {
        return $this->image ? $this->image->getFile() : '';
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
