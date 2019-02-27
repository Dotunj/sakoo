<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    protected $fillable = ['number', 'notification_on'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
