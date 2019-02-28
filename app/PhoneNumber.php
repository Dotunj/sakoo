<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    protected $fillable = ['identifier', 'number', 'notification_on'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($number) {
            $number->identifier = uniqid();
        });
    }

    public function getRouteKeyName()
    {
        return "identifier";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
