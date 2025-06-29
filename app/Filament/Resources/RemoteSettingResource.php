<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RemoteSettingResource\Pages;
use App\Filament\Resources\RemoteSettingResource\RelationManagers;
use App\Forms\Components\CodeEditor;
use App\Models\RemoteSetting;
use Creagia\FilamentCodeField\CodeField;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RemoteSettingResource extends Resource
{
    protected static ?string $model = RemoteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('resources.remote_setting');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.remote_settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.remote_settings');
    }

    // public static function getNavigationGroup(): ?string
    // {
    //     return __('resources.remote_settings');
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('country_code')
                    ->required()
                    ->maxLength(10)
                    ->label(__('resources.country_code')),
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(50)
                    ->default('json')
                    ->label(__('resources.type')),
                // Forms\Components\Textarea::make('value')
                //     ->columnSpanFull()
                //     ->label(__('resources.value')),
                // CodeEditor::make('payload')
                //     ->label('JSON Payload')
                //     ->language('json')   // ace/mode/…
                //     ->columnSpanFull()
                //     ->required(),
                // CodeField::make('my_json'),

                CodeField::make('value')
                    ->setLanguage('json')          // any CodeMirror language id
                    ->htmlField()
                    ->disableAutocompletion()
                    ->withLineNumbers()
                    ->columnSpanFull()
                    ->required()
                    ->label(__('resources.value')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('country_code')
                    ->searchable()
                    ->label(__('resources.country_code')),
                Tables\Columns\TextColumn::make('type')
                    ->searchable()
                    ->label(__('resources.type')),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('resources.created_at')),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('resources.updated_at')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRemoteSettings::route('/'),
            'create' => Pages\CreateRemoteSetting::route('/create'),
            'edit' => Pages\EditRemoteSetting::route('/{record}/edit'),
        ];
    }
}
