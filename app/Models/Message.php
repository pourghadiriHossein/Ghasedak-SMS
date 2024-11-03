<?php

namespace App\Models;

use App\Modules\Convertor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'API_key',
        'template',
        'param',
    ];
    public function receptors(){
        return $this->hasMany(Receptor::class);
    }
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => is_null($value) ? null : Convertor::datetime_gregorianToJalali(Carbon::make($value)),
        );
    }
}
