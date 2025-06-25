<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    /** @use HasFactory<\Database\Factories\SubscriptionFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'plan_id', 'start_date', 'end_date', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class); // A subscription belongs to a user
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class); // A subscription belongs to a plan
    }
}
