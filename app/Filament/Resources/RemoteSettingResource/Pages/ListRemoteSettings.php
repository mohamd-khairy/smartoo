<?php

namespace App\Filament\Resources\RemoteSettingResource\Pages;

use App\Filament\Resources\RemoteSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRemoteSettings extends ListRecords
{
    protected static string $resource = RemoteSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
