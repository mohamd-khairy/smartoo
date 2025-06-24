<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    /** @use HasFactory<\Database\Factories\TranslationFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'key',
        'value',
    ];

    public static function getTranslation($language, $key)
    {
        return self::where('code', $language)
            ->where('key', $key)
            ->first();
    }
}
