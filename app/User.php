<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'trial_reminder_sent'
    ];

    protected $appends = ['notifications_sent_today'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function drift()
    {
        return $this->hasMany(DriftToken::class);
    }

    public function phoneNumbers()
    {
        return $this->hasMany(PhoneNumber::class);
    }

    public function notifiablePhoneNumbers()
    {
        return $this->hasMany(PhoneNumber::class)->where('notification_on', true);
    }

    public function logEntry()
    {
        return $this->hasMany(LogEntry::class);
    }

    public function successfulLogEntries()
    {
        return $this->hasMany(LogEntry::class)->where('status', true);
    }

    public function createLogEntry()
    {
        $logEntry = $this->logEntry()->create([
            'status' => true
        ]);
        
        return $logEntry;
    }

    public function successfulLogEntriesCount()
    {
        return $this->successfulLogEntries()->count();
    }

    public function getNotificationsSentTodayAttribute()
    {
        return $this->notificationsSentToday();
    }

    public function isStillEligibleForTrial()
    {
        if ($this->successfulLogEntries()->count() <= 20) {
            return true;
        }

        return false;
    }

    public function scopeUsersYetToSubscribe($query)
    {
        return $query->whereNull('stripe_id')->where('trial_reminder_sent', false)->get();
    }

    public function notificationsSentToday()
    {
        return $this->successfulLogEntries()->whereDate('created_at', today())->count();
    }
}
