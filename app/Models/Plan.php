<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Plan extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'currency', 'duration_days', 'status'];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class); // A plan can have many subscriptions
    }
}
