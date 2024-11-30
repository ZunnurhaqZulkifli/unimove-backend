<?php

namespace App\Livewire;

use App\Models\Driver;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DriverTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function render()
    {
        return view('livewire.driver-table');
    }

    public function getMainTableQuery()
    {
        return DB::table('drivers')
            ->select('id', 'user_id');
    }

    public function table(Table $table): Table
    {
        return $table->query(Driver::query())
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Name')
                    ->sortable(),
                    
                TextColumn::make('phone')
                    ->label('Phone')
                    ->sortable(),
                
                TextColumn::make('address')
                    ->label('address')
                    ->sortable(),
                
                TextColumn::make('driver_id')
                    ->label('driver_id')
                    ->sortable(),

                TextColumn::make('license_no')
                    ->label('license_no')
                    ->sortable(),

                TextColumn::make('license_expiry')
                    ->date()
                    ->label('license_expiry'),
            
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('create_driver')
                    ->label('Create Driver')
                    ->modalHeading('Create A New Driver')
                    ->form([
                        TextInput::make('name')
                            ->label('Name')
                            ->numeric()
                            ->required(),
                        
                    ])
                    ->action(function (array $data) {

                        dd($data);
                        // Driver::create([
                        //     'name' => $data['name'],
                        // ]);
                    }),
            ]);
    }
}
