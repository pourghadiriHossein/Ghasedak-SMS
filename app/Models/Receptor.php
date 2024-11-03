<?php

namespace App\Models;

use App\Modules\Convertor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Receptor extends Model
{
    protected $fillable = [
        'message_id',
        'row',
        'phone',
    ];
    public function message() {
        return $this->belongsTo(Message::class);
    }
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => is_null($value) ? null : Convertor::datetime_gregorianToJalali(Carbon::make($value)),
        );
    }
}
