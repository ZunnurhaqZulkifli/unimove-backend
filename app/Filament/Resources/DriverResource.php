<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DriverResource\Pages;
use App\Models\Driver;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Driver Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('id_number')->required(),
                Forms\Components\TextInput::make('phone')->required()->email(),
                Forms\Components\TextInput::make('driver_id')->required(),
                Forms\Components\TextInput::make('license_no')->required(),
                Forms\Components\TextInput::make('license_expiry')->required(),
                Forms\Components\TextInput::make('address')->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                ->required(),
                Forms\Components\TextInput::make('address')->required(),
                Forms\Components\TextInput::make('profile_picture')->required(),
                Forms\Components\TextInput::make('ratings')->required(),
                Forms\Components\TextInput::make('total_trips')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Name'),
                Tables\Columns\TextColumn::make('id_number')->label('id_number'),
                Tables\Columns\TextColumn::make('phone')->label('Phone'),
                Tables\Columns\TextColumn::make('driver_id')->label('Driver ID'),
                Tables\Columns\TextColumn::make('license_no')->label('License No'),
                Tables\Columns\TextColumn::make('license_expiry')->label('License Expiry'),
                Tables\Columns\TextColumn::make('address')->label('Address'),
                Tables\Columns\TextColumn::make('status')->label('Status'),
                Tables\Columns\TextColumn::make('profile_picture')->label('Profile Picture'),
                Tables\Columns\TextColumn::make('ratings')->label('Ratings'),
                Tables\Columns\TextColumn::make('total_trips')->label('Total Trips'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
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
            'index' => Pages\ListDrivers::route('/'),
            'create' => Pages\CreateDriver::route('/create'),
            'edit' => Pages\EditDriver::route('/{record}/edit'),
        ];
    }
}
