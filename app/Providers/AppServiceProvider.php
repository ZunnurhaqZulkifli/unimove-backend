<?php

namespace App\Providers;

use App\Filament\Pages\Drivers;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        Filament::registerResources([
            Drivers::class,
        ]);
    }
}
