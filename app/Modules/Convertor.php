<?php

namespace App\Modules;

use Carbon\Carbon;
use Morilog\Jalali\Jalalian;

class Convertor {
    public static function date_jalaliToGregorian ($date){
        return Jalalian::fromFormat('Y/m/d', strval($date))->toCarbon();
    }
    public static function datetime_gregorianToJalali ($datetime){
        return Jalalian::fromCarbon($datetime)->format('Y/m/d H:i');
    }
}
