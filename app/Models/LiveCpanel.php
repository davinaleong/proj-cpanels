<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LiveCpanel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function getProjectName()
    {
        return $this->project ? $this->project->name : '';
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
