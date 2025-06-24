<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemoteSetting extends Model
{
    /** @use HasFactory<\Database\Factories\RemoteSettingFactory> */
    use HasFactory;

    protected $fillable = [
        'country_code',
        'type',
        'value',
    ];

    protected $casts = [
        'value' => 'array',
    ];
}
