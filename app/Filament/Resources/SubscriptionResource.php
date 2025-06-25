<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionResource\Pages;
use App\Filament\Resources\SubscriptionResource\RelationManagers;
use App\Models\Subscription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('resources.subscription');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.subscriptions');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.subscriptions');
    }

    // public static function getNavigationGroup(): ?string
    // {
    //     return __('resources.subscriptions');
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric()
                    ->label(__('resources.user_id')),
                Forms\Components\TextInput::make('plan_id')
                    ->required()
                    ->numeric()
                    ->label(__('resources.plan_id')),
                Forms\Components\DatePicker::make('start_date')
                    ->required()
                    ->label(__('resources.start_date')),
                Forms\Components\DatePicker::make('end_date')
                    ->required()
                    ->label(__('resources.end_date')),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->label(__('resources.status')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable()
                    ->label(__('resources.user_id')),
                Tables\Columns\TextColumn::make('plan_id')
                    ->numeric()
                    ->sortable()
                    ->label(__('resources.plan_id')),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable()
                    ->label(__('resources.start_date')),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable()
                    ->label(__('resources.end_date')),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('resources.status')),
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
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
