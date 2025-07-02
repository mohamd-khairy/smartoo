<?php

namespace App\Filament\Resources\TranslationResource\Pages;

use App\Filament\Resources\AuditResource;
use App\Filament\Resources\PlanResource;
use App\Filament\Resources\RemoteSettingResource;
use App\Filament\Resources\SubscriptionResource;
use App\Filament\Resources\TranslationResource;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ShowAudit extends ViewRecord
{
    protected static string $resource = TranslationResource::class;
}
