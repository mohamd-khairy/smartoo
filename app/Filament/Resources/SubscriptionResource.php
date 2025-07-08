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

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

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

                Forms\Components\TextInput::make('original_transaction_id')
                    ->required()
                    ->label(__('resources.original_transaction_id')),

                Forms\Components\TextInput::make('product_id')
                    ->required()
                    ->label(__('resources.product_id')),

                Forms\Components\ToggleButtons::make('status')
                    ->options([
                        'active' => __('resources.active'),
                        'inactive' => __('resources.inactive'),
                        'expired' => __('resources.expired'),
                    ])
                    ->required()
                    ->label(__('resources.status')),

                Forms\Components\ToggleButtons::make('is_renewal')
                    ->label('is_renewal?')
                    ->boolean()
                    ->grouped(),

                Forms\Components\DatePicker::make('expires_at')
                    ->required()
                    ->label(__('resources.expires_at')),
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

                Tables\Columns\TextColumn::make('original_transaction_id')
                    ->label(__('resources.original_transaction_id')),

                Tables\Columns\TextColumn::make('product_id')
                    ->label(__('resources.product_id')),

                Tables\Columns\ToggleColumn::make('is_renewal')
                    ->label(__('resources.is_renewal')),

                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'active' => __('resources.active'),
                        'inactive' => __('resources.inactive'),
                        'expired' => __('resources.expired'),
                    ])
                    ->label(__('resources.status')),

                Tables\Columns\TextColumn::make('expires_at')
                    ->date()
                    ->sortable()
                    ->label(__('resources.expires_at')),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
            'show' => Pages\ShowAudit::route('/{record}'),
        ];
    }
}
