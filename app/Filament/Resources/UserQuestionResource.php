<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserQuestionResource\Pages;
use App\Filament\Resources\UserQuestionResource\RelationManagers;
use App\Models\UserQuestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserQuestionResource extends Resource
{
    protected static ?string $model = UserQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('resources.question');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.questions');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.questions');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255)
                    ->label(__('resources.phone')),
                Forms\Components\Textarea::make('question')
                    ->columnSpanFull()
                    ->label(__('resources.question')),
                Forms\Components\ToggleButtons::make('status')
                    ->options([
                        'pending' => __('resources.pending'),
                        'approved' => __('resources.approved'),
                        'rejected' => __('resources.rejected'),
                    ])
                    ->required()
                    ->label(__('resources.status')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()
                    ->label(__('resources.id')),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->label(__('resources.phone')),
                Tables\Columns\TextColumn::make('question')
                    ->searchable()
                    ->label(__('resources.question')),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'pending' => __('resources.pending'),
                        'approved' => __('resources.approved'),
                        'rejected' => __('resources.rejected'),
                    ])
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
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUserQuestions::route('/'),
            // 'create' => Pages\CreateUserQuestion::route('/create'),
            // 'edit' => Pages\EditUserQuestion::route('/{record}/edit'),
            'show' => Pages\ShowAudit::route('/{record}'),
        ];
    }
}
