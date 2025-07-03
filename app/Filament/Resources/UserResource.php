<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getModelLabel(): string
    {
        return __('resources.user');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.users');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.users');
    }

    // public static function getNavigationGroup(): ?string
    // {
    //     return __('resources.users');
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->maxLength(255)
                    ->label(__('resources.name')),
                Forms\Components\TextInput::make('uuid')
                    ->maxLength(255)
                    ->label(__('resources.uuid')),
                Forms\Components\TextInput::make('oc')
                    ->maxLength(255)
                    ->label(__('resources.oc')),
                Forms\Components\TextInput::make('app_version')
                    ->maxLength(255)
                    ->label(__('resources.app_version')),
                Forms\Components\TextInput::make('client_id')
                    ->maxLength(255)
                    ->label(__('resources.client_id')),
                Forms\Components\TextInput::make('client_secret')
                    ->maxLength(255)
                    ->label(__('resources.client_secret')),
                Forms\Components\TextInput::make('device_type')
                    ->maxLength(255)
                    ->label(__('resources.device_type')),
                // Forms\Components\TextInput::make('email')
                //     ->email()
                //     ->maxLength(255)
                //     ->label(__('resources.email')),
                // Forms\Components\TextInput::make('password')
                //     ->password()
                //     ->maxLength(255)
                //     ->label(__('resources.password')),
                Forms\Components\TextInput::make('country_code')
                    ->maxLength(255)
                    ->default('EG')
                    ->label(__('resources.country_code')),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255)
                    ->label(__('resources.phone')),
                // Forms\Components\TextInput::make('role')
                //     ->required()
                //     ->maxLength(255)
                //     ->default('user')
                //     ->label(__('resources.role')),
                Forms\Components\TextInput::make('locale')
                    ->required()
                    ->maxLength(255)
                    ->default('en')
                    ->label(__('resources.locale')),
                // Forms\Components\TextInput::make('status')
                //     ->required()
                //     ->maxLength(255)
                //     ->default('pending')
                //     ->label(__('resources.status')),
                // Forms\Components\TextInput::make('timezone')
                //     ->maxLength(255)
                //     ->label(__('resources.timezone')),
                // Forms\Components\FileUpload::make('image')
                //     ->columnSpanFull()
                //     ->label(__('resources.image'))
                //     ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()
                    ->label(__('resources.id')),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label(__('resources.name')),
                Tables\Columns\TextColumn::make('uuid')
                    ->searchable()
                    ->label(__('resources.uuid')),
                Tables\Columns\TextColumn::make('oc')
                    ->searchable()
                    ->label(__('resources.oc')),
                Tables\Columns\TextColumn::make('app_version')
                    ->searchable()
                    ->label(__('resources.app_version')),
                Tables\Columns\TextColumn::make('client_id')
                    ->searchable()
                    ->label(__('resources.client_id')),
                Tables\Columns\TextColumn::make('client_secret')
                    ->searchable()
                    ->label(__('resources.client_secret')),
                Tables\Columns\TextColumn::make('password')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('resources.password')),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('resources.email')),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('resources.email_verified_at')),
                Tables\Columns\TextColumn::make('country_code')
                    ->searchable()
                    ->label(__('resources.country_code')),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->label(__('resources.phone')),
                Tables\Columns\TextColumn::make('phone_verification_code')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('resources.phone_verification_code')),
                Tables\Columns\TextColumn::make('phone_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('resources.phone_verified_at')),
                Tables\Columns\TextColumn::make('role')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('resources.role')),
                Tables\Columns\TextColumn::make('locale')
                    ->searchable()
                    ->label(__('resources.locale')),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('resources.status')),
                Tables\Columns\TextColumn::make('device_type')
                    ->searchable()
                    ->label(__('resources.device_type')),
                Tables\Columns\TextColumn::make('mac_address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('resources.mac_address')),
                Tables\Columns\TextColumn::make('ip_address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('resources.ip_address')),
                Tables\Columns\TextColumn::make('timezone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('resources.timezone')),
                Tables\Columns\TextColumn::make('last_login_at')
                    ->dateTime()
                    ->sortable()
                    ->label(__('resources.last_login_at')),
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
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'show' => Pages\ShowAudit::route('/{record}'),
        ];
    }
}
