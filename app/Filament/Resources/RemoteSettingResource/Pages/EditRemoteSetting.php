<?php

namespace App\Filament\Resources\RemoteSettingResource\Pages;

use App\Filament\Resources\RemoteSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRemoteSetting extends EditRecord
{
    protected static string $resource = RemoteSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
