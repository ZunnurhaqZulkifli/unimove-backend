<?php

namespace App\Livewire;

use App\Models\User;
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

class UserTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function render()
    {
        return view('livewire.user-table');
    }

    public function getMainTableQuery()
    {
        return DB::table('users')
            ->select('id');
    }

    public function table(Table $table): Table
    {
        return $table
        ->heading('Xiao Hong Shu')
        ->query(User::query())
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable(),

                TextColumn::make('username')
                    ->label('Username')
                    ->sortable(),

                TextColumn::make('typeable_type')
                    ->label('Profile Type')
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                
            ])
            ->headerActions([
                Action::make('create_user')
                ->label('Create User')
                ->modalHeading('Create A New User')
                ->form([
                    TextInput::make('name')
                        ->label('Name')
                        ->numeric()
                        ->required(),
                    
                ])->action(function (array $data) {

                    dd($data);
                    // Driver::create([
                    //     'name' => $data['name'],
                    // ]);
                }),
            ]);
    }
}
