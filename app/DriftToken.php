<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriftToken extends Model
{
    protected $fillable = ['organization_id', 'access_token', 'refresh_token'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
