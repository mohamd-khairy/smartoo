<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Subscription extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'original_transaction_id', 'product_id', 'is_renewal', 'status', 'expires_at', 'data', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class); // A subscription belongs to a user
    }
}
