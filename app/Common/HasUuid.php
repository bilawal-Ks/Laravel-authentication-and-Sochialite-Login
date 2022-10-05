<?php

namespace App\Common;

use Illuminate\Support\Str;

trait HasUuid
{
    public static function bootHasUUID() : void
    {
        static::creating(function($model){
           $model->uuid = Str::uuid()->toString();
        });
    }
}