<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TranslationResource\Pages;
use App\Filament\Resources\TranslationResource\RelationManagers;
use App\Models\Translation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TranslationResource extends Resource
{
    protected static ?string $model = Translation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('resources.translation');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.translations');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.translations');
    }

    // public static function getNavigationGroup(): ?string
    // {
    //     return __('resources.translations');
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->required()
                    ->columnSpanFull()
                    ->label(__('resources.key')),

                Forms\Components\Repeater::make('value')
                    ->label('Language Translations')
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\TextInput::make('lang')
                            ->required()
                            ->maxLength(10)
                            ->default('en')
                            ->label(__('resources.code')),

                        Forms\Components\TextInput::make('val')
                            ->required()
                            ->label(__('resources.value')),
                    ])
                    ->defaultItems(1)
                    ->reorderable()
                    ->cloneable()
                    ->addActionLabel('+ Add Language')
                    ->minItems(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->label(__('resources.code')),
                Tables\Columns\TextColumn::make('key')
                    ->searchable()
                    ->label(__('resources.key')),
                Tables\Columns\TextColumn::make('value')
                    ->searchable()
                    ->label(__('resources.value')),
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
            'index' => Pages\ListTranslations::route('/'),
            'create' => Pages\CreateTranslation::route('/create'),
            'edit' => Pages\EditTranslation::route('/{record}/edit'),
        ];
    }
}
