<?php

namespace App\Livewire;

use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class VehicleTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $driver;
    public $canAddVehicles = true;
    public $brand_id;
    public $models = [];
    public $mileage;

    public function updatedBrandId($value)
    {
        $this->models = VehicleModel::where('brand_id', $value)->pluck('name', 'id')->toArray();
    }

    public function mount(Driver $driver)
    {
        $this->driver = $driver;

        if ($this->driver->vehicles->count() > 1) {
            $this->canAddVehicles = false;
        }
    }

    public function calculateMileage()
    {
        // echo "dua";
        $driver = Driver::find($this->driver->id);
        $driver->mileage = Vehicle::where('driver_id', $this->driver->id)->sum('mileage');
        $driver->save();

        $mileage = Vehicle::where('driver_id', $this->driver->id)->sum('mileage');
        $this->mileage = $mileage;

        $this->js("window.location.reload()"); 
    }

    public function render()
    {
        // echo "tiga";
        return view('livewire.vehicle-table');
    }

    public function getMainTableQuery()
    {
        return DB::table('vehicles')
            ->select('id');
    }

    public function table(Table $table): Table
    {
        return $table
        ->heading('Vehicles')
        ->query(Vehicle::query()->where('driver_id', $this->driver->id))
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                
                TextColumn::make('plate_no')
                    ->label('Plate Number')
                    ->sortable(),

                TextColumn::make('brand_id')
                    ->formatStateUsing(fn ($state) => $state ? VehicleBrand::find($state)->name : 'N/A')
                    ->label('Brand')
                    ->sortable(),

                TextColumn::make('model_id')
                    ->formatStateUsing(fn ($state) => $state ? VehicleModel::find($state)->name : 'N/A')
                    ->label('Model'),

                TextColumn::make('color')
                    ->formatStateUsing(fn ($state) => $state ? ucfirst($state) : 'N/A')
                    ->label('Color')
                    ->sortable(),

                TextColumn::make('mileage')
                    ->label('Mileage')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('created_at')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // DeleteAction::make('delete_vehicle')
                //     ->modalHeading('Delete Vehicle')
                //     ->modalDescription('Are you sure you want to delete this vehicle? This action cannot be undone.')
                //     ->successNotificationTitle('Vehicle Deleted')
                //     ->requiresConfirmation(),

                Action::make('delete')
                    ->visible(fn () => !$this->canAddVehicles)
                    ->label('Delete Vehicle')
                    ->modalHeading('Delete Vehicle')
                    ->modalDescription('Are you sure you want to delete this vehicle? This action cannot be undone.')
                    ->successRedirectUrl(env('APP_URL') . '/admin/driverse')
                    ->action(function (Vehicle $record) {
                        $record->delete();

                        if($this->driver->vehicles->count() < 2){
                            $this->canAddVehicles = true;
                        }

                        $this->calculateMileage();
                    }),
            ])
            ->headerActions([
                Action::make('create_vehicle')
                    ->label('Create Vehicle')
                    ->visible(fn () => $this->canAddVehicles)
                    ->modalHeading('Create A New Vehicle')
                    ->successRedirectUrl(env('APP_URL') . '/admin/driverse')
                    ->form([

                        TextInput::make('driver_id')
                            ->default($this->driver->id)
                            ->readOnly()
                            ->label('driver_id'),
                        
                        TextInput::make('plate_no')
                            ->label('plate_no'),

                        Select::make('brand_id')
                            ->options(VehicleBrand::all()->pluck('name', 'id'))
                            ->reactive()
                            ->afterStateUpdated(fn ($state) => $this->updatedBrandId($state))
                            ->label('Vehicle Brand'),

                        Select::make('model_id')
                            ->options(fn () => $this->models)
                            ->label('Vehicle Model'),

                        TextInput::make('mileage')
                            ->numeric()
                            ->label('Mileage'),
        
                        Select::make('color')
                            ->options([
                                'red' => 'red',
                                'blue' => 'blue',
                                'green' => 'green',
                                'yellow' => 'yellow',
                                'black' => 'black',
                                'white' => 'white',
                                'silver' => 'silver',
                                'grey' => 'grey',
                                'brown' => 'brown',
                                'orange' => 'orange',
                                'purple' => 'purple',
                                'pink' => 'pink',
                                'gold' => 'gold',
                            ])
                            ->label('color'),

                    ])->action(function (array $data) {
                        Vehicle::create([
                            'driver_id' => $data['driver_id'],
                            'plate_no' => $data['plate_no'],
                            'brand_id' => $data['brand_id'],
                            'model_id' => $data['model_id'],
                            'mileage' => $data['mileage'],
                            'color' => $data['color'],
                            'status' => 'active',
                            'created_at' => now(),
                        ]);

                        if($this->driver->vehicles->count() >= 2) {
                            $this->canAddVehicles = false;
                        }
                        $this->calculateMileage();
                    }),
                ])->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
