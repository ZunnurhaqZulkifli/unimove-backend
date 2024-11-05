<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReasonResource\Pages;
use App\Filament\Resources\ReasonResource\RelationManagers;
use App\Models\Reason;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReasonResource extends Resource
{
    protected static ?string $model = Reason::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('label')->required(),
                Forms\Components\TextInput::make('value')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')->label('Label'),
                Tables\Columns\TextColumn::make('value')->label('Value'),
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
            'index' => Pages\ListReasons::route('/'),
            'create' => Pages\CreateReason::route('/create'),
            'edit' => Pages\EditReason::route('/{record}/edit'),
        ];
    }
}
