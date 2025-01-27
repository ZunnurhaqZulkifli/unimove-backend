<?php

namespace App\Filament\Pages;

use App\Models\Driver;
use App\Models\User;
use App\Models\Vehicle;
use Filament\Forms\Components\DatePicker;
use Filament\Infolists\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Pages\Page;

class Drivers extends Page implements HasForms, HasInfolists
{
    use InteractsWithForms;
    use InteractsWithInfolists;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.drivers';
    protected static ?string $navigationGroup = 'Payments';

    public $model;
    public $mileage;
    public $totalCars;

    public function __construct()
    {
        $this->model = Driver::find(1);
        $this->totalCars = $this->model->vehicles->count();
        $this->mileage = Vehicle::where('driver_id', $this->model->id)->sum('mileage');
    }

    public function infolist(Infolist $infoList): InfoList
    {
        return $infoList
        ->record(Driver::find(1))->schema([
            Section::make('Driver Information')->columns(2)->schema([
                TextEntry::make('name')
                    ->label('Name'),

                TextEntry::make('phone')
                    ->label('Phone'),

                TextEntry::make('address')
                    ->label('Address'),

                TextEntry::make('driver_id')
                    ->label('Driver ID'),

                TextEntry::make('license_no')
                    ->label('License No'),

                TextEntry::make('license_expiry')
                    ->label('License Expiry'),

                TextEntry::make('created_at')
                    ->label('Created At'),
                
                TextEntry::make('mileage')
                    ->default($this->mileage)
                    ->label('Milage'),
            ]),
        ])->columns(2);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->required()
                    ->maxLength(20),
                
                TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                
                TextInput::make('driver_id')
                    ->required()
                    ->maxLength(20),

                TextInput::make('license_no')
                    ->required()
                    ->maxLength(20),

                DatePicker::make('license_expiry')
                    ->required(),

                TextInput::make('license_no')
                    ->required()
                    ->maxLength(20),

                TextInput::make('created_at')
                    ->disabled()
                    ->default(now())
                    ->hidden()
                    
            //     Repeater::make('paymentFunds')
            //     ->label('Payment Funds')
            //     ->relationship('paymentFunds') // Correctly defined in the model
            //     ->schema([
            //         Select::make('fund_id')
            //             ->label('Fund')
            //             ->options(Fund::all()->pluck('name', 'id'))
            //             ->searchable()
            //             ->required(),
            //         TextInput::make('amount')
            //             ->label('Amount')
            //             ->numeric()
            //             ->required(),
            //     ])
            //     ->columns(2)
            //     ->nullable() // Allow the repeater to be empty
            //     ->addActionLabel('Add Fund')
            //     ->default([]),
            ])
            ->columns(1)
            ->operation('create');
    }

    public static function canGloballySearch(): bool
    {
        return true;
    }
}
