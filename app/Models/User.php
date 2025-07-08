<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'uuid',
        'app_version',
        'oc',
        'client_secret',
        'client_id',
        'device_type',
        'country_code',

        'locale',
        'phone',
        'name',
        'email',
        'password',
        'phone_verification_code',
        'phone_verified_at',
        'role',
        'status',
        'timezone',
        'last_login_at',
        'device_token',
        'ip_address',
        'mac_address',
        'email_verified_at',
        'image',
        'gender',
        'contact_permission',
        'notification_permission',
        'tracking_permission',
        'subscription_id'
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

    protected $auditExclude = [
        'last_login_at',
    ];

    public function getNameAttrbute($value)
    {
        return $value ?? 'guest' . $this->attributes['uuid'];
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
}
