<?php

namespace App\Filament\Resources\RemoteSettingResource\Pages;

use App\Filament\Resources\AuditResource;
use App\Filament\Resources\PlanResource;
use App\Filament\Resources\RemoteSettingResource;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ShowAudit extends ViewRecord
{
    protected static string $resource = RemoteSettingResource::class;
}
