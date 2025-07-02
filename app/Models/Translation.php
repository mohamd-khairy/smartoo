<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Translation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = [
        'key',
        'translations',
    ];

    protected $casts = [
        'translations' => 'json',
    ];

    protected $appends = [
        'value'
    ];

    public function getValueAttribute($value)
    {
        // Get the current language (you can define how to get this dynamically or statically)
        $currentLanguage = app()->getLocale(); // Get the current language, e.g., 'en' or 'ar'

        // Find the translation for the current language
        $translation = collect($this->translations)->firstWhere('lang', $currentLanguage);

        // If the translation exists, return the 'val' field, otherwise return null
        return $translation ? $translation['val'] : null;
    }
}
