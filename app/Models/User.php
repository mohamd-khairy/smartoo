<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
        'phone',
        'phone_verification_code',
        'phone_verified_at',
        'locale',
        'role',
        'status',
        'timezone',
        'last_login_at',
        'device_token',
        'device_type',
        'ip_address',
        'mac_address',
        'email_verified_at',
        'country_code',
        'image',
        'gender',
        'contact_permission',
        'notification_permission',
        'tracking_permission',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function setNameAttribute($value)
    {
        if ($value) {
            $this->attributes['name'] = $value;
        } else {
            $this->attributes['name'] = $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
        }
    }

    public function getNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    public function setImageAttribute($value)
    {
        if (!strpos($value, 'http')) {
            $this->attributes['image'] = $value ? $value->store('images', 'public') : null;
        } else {
            $this->attributes['image'] = $value;
        }
    }

    public function getImageAttribute($value)
    {
        if (!strpos($value, 'http')) {
            return $value ? url('storage/' . $value) : null;
        } else {
            return $value ?? null;
        }
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class)->latestOfMany(); // A user has one subscription
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class); // A user has many subscriptions
    }
}
