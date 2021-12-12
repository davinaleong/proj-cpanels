<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdditionalDataGroup extends Model
{
    use HasFactory;
    use SoftDeletes;

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
