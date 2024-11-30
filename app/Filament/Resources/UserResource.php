<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\Grid as ComponentsGrid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Carbon\Carbon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // protected static ?string $navigationGroup = 'Administration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('typeable_type')
                    ->options([
                        'App\Models\Student' => 'Student',
                        'App\Models\Staff'   => 'Staff',
                        'App\Models\Driver'  => 'Driver',
                    ])
                    ->live()
                    ->default('App\Models\Student')
                    ->required(),
                    
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('username')->required(),
                Forms\Components\TextInput::make('email')->required()->email(),
                Forms\Components\TextInput::make('password')
                    ->hiddenOn('edit')
                    ->password()
                    ->required(),

                Grid::make(2)
                    ->label('Models')
                    // ->hiddenOn('edit')
                    ->schema(fn(Get $get): array=> match ($get('typeable_type')) {
                        'App\Models\Student'        => [
                            Forms\Components\TextInput::make('student_id')
                                ->required(),

                            Forms\Components\TextInput::make('student_phone')
                                ->label('Phone')
                                ->required(),

                            Forms\Components\TextInput::make('student_address')
                                ->label('Address')
                                ->required(),
                        ],
                        'App\Models\Staff'          => [
                            Forms\Components\TextInput::make('staff_id')
                                ->required(),

                            Forms\Components\TextInput::make('staff_phone')
                                ->label('Phone')
                                ->required(),

                            Forms\Components\TextInput::make('staff_address')
                                ->label('Address')
                                ->required(),
                        ],
                        'App\Models\Driver'         => [
                            Forms\Components\TextInput::make('driver_id')
                                ->required(),

                            Forms\Components\TextInput::make('driver_phone')
                                ->label('Phone')
                                ->required(),

                            Forms\Components\TextInput::make('driver_address')
                                ->label('Address')
                                ->required(),

                            Forms\Components\TextInput::make('driver_license_no')
                                ->label('License No')
                                ->required(),

                            Forms\Components\DatePicker::make('driver_license_expiry')
                                ->label('License Expiry')
                                ->required(),
                        ],
                        default                     => [],
                    })
                    ->key('dynamicTypeFields'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Name'),
                Tables\Columns\TextColumn::make('username')->label('Username'),
                Tables\Columns\TextColumn::make('email')->label('Email'),
                Tables\Columns\TextColumn::make('email_verified_at')->label('Email Verified At')->dateTime(),
                Tables\Columns\TextColumn::make('created_at')->label('Created At')->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->label('Updated At')->dateTime(),
            ])
            ->filters([
                // SelectFilter::make('role')
                //     ->label('Role')
                //     ->options([
                //         'admin' => 'Admin',
                //         'student' => 'Student',
                //         'driver' => 'Driver',
                //     ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->heading('User Account')
                    ->schema([
                        ComponentsGrid::make()
                            ->columns(2)
                            ->schema([
                                TextEntry::make('id')->label('ID'),
                                TextEntry::make('name')->label('Name'),
                                TextEntry::make('username')->label('Username'),
                                TextEntry::make('email')->label('Email'),
                                TextEntry::make('email_verified_at')->label('Email Verified At'),
                                TextEntry::make('created_at')->label('Created At'),
                                TextEntry::make('updated_at')->label('Updated At'),
                            ]),
                    ]),

                // Split::make([
                //     Section::make([
                //         TextEntry::make('name')
                //             ->weight(FontWeight::ExtraBold),

                //         TextEntry::make('username')
                //             ->weight(FontWeight::ExtraBold),
                //     ]),
                //     Section::make([
                //         TextEntry::make('email')
                //             ->weight(FontWeight::ExtraBold),

                //         TextEntry::make('verified_at')
                //             ->dateTime(),
                //     ])->grow(false),
                // ])->from('xl'),

                Tabs::make('Tabs')
                    ->hidden( fn ($record)=>
                        // dd(Auth::user()), // can be used to debug
                        Auth::user()->name === 'System Administrator' ? false :
                        $record->typeable_type === null
                    )
                    ->tabs([
                        Tabs\Tab::make('Profile')
                        ->icon('heroicon-m-bell')
                            ->schema([
                                TextEntry::make('profile.id')->label('ID'),
                            ]),
                        Tabs\Tab::make('Wallet')
                            ->hidden(fn($record) => $record->typeable_type !== 'App\Models\Driver')
                            ->schema([
                                // ...
                            ]),
                        Tabs\Tab::make('Vehicle')
                            ->schema([
                                // ...
                            ]),
                    ]),

                Section::make()
                    ->hidden(fn($record) => $record->typeable_type === null)
                    ->heading('Profile')
                    ->columns([
                        'sm'  => 3,
                        'xl'  => 6,
                        '2xl' => 8,
                    ])
                    ->schema(function ($record) {
                        return match ($record->typeable_type) {
                            'App\Models\Student' => [
                                TextEntry::make('profile.id')->label('Student ID'),
                                TextEntry::make('profile.name')->label('Student Name'),
                                TextEntry::make('profile.phone')->label('Student Phone'),
                                TextEntry::make('profile.address')->label('Student Address'),
                                TextEntry::make('profile.status')->badge()
                                ->label('Account Status')
                                ->color(fn (string $state): string => match ($state) {
                                    'unactive' => 'warning',
                                    'active' => 'success',
                                }),
                                TextEntry::make('profile.verified')->badge()
                                ->label('Account Status')
                                ->color(fn (bool $state): string => $state ? 'success' : 'warning')
                                ->formatStateUsing(fn (bool $state): string => $state ? 'Verified' : 'Unverified'),
                            ],
                            'App\Models\Staff'   => [
                                TextEntry::make('profile.id')->label('Staff ID'),
                                TextEntry::make('profile.name')->label('Staff Name'),
                                TextEntry::make('profile.phone')->label('Staff Phone'),
                                TextEntry::make('profile.address')->label('Staff Address'),
                                TextEntry::make('profile.status')->badge()
                                ->label('Account Status')
                                ->color(fn (string $state): string => match ($state) {
                                    'unactive' => 'warning',
                                    'active' => 'success',
                                }),
                                TextEntry::make('profile.verified')->badge()
                                ->label('Account Status')
                                ->color(fn (bool $state): string => $state ? 'success' : 'warning')
                                ->formatStateUsing(fn (bool $state): string => $state ? 'Verified' : 'Unverified'),
                            ],
                            'App\Models\Driver'  => [
                                TextEntry::make('profile.id')->label('Driver ID'),
                                TextEntry::make('profile.name')->label('Driver Name'),
                                TextEntry::make('profile.phone')->label('Driver Phone'),
                                TextEntry::make('profile.address')->label('Driver Address'),
                                TextEntry::make('profile.driver_id')->label('Assigned Driver ID'),
                                TextEntry::make('profile.license_no')->label('Lisece No'),
                                TextEntry::make('profile.license_expiry')->label('License Expiry Date')
                                    ->formatStateUsing(
                                        fn (string $state): string => Carbon::parse($state)->isBefore(Carbon::now()) ? 'Expired : ' . $state : 'Valid : ' . $state
                                    )
                                    ->color(
                                        fn (string $state): string => Carbon::parse($state)->isBefore(Carbon::now()) ? 'danger' : 'success'
                                    )->badge(),
                                

                                TextEntry::make('profile.status')->badge()
                                    ->label('Account Status')
                                    ->color(fn (string $state): string => match ($state) {
                                        'unactive' => 'warning',
                                        'active' => 'success',
                                    }),

                                TextEntry::make('profile.verified')->badge()
                                    ->label('Account Status')
                                    ->color(fn (bool $state): string => $state ? 'success' : 'warning')
                                    ->formatStateUsing(fn (bool $state): string => $state ? 'Verified' : 'Unverified'),
                            ],
                            default              => [],
                        };
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view'   => Pages\ViewUser::route('/{record}'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
