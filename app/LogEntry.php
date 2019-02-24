<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogEntry extends Model
{
    protected $fillable = ['user_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createLog($user)
    {
        $logEntry = static::create([
            'user_id' => $user->id,
            'status' => true
        ]);
        
        return $logEntry;
    }
}
