<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model implements \OwenIt\Auditing\Contracts\Audit
{
    use \OwenIt\Auditing\Audit;

    /**
     * @var string[]
     */
    protected $guarded = [];
    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
        'tags' => 'json',
    ];

    public function getSerializedDate($date): string
    {
        return $this->serializeDate($date);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = auth()->id() ?? null;
            $model->user_type = auth()->user() ? get_class(auth()->user()) : null;
        });

        static::updating(function ($model) {
            $model->user_id = auth()->id() ?? null;
            $model->user_type = auth()->user() ? get_class(auth()->user()) : null;
        });
    }
}
