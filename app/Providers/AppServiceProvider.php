<?php

namespace App\Providers;

use App\Filament\Auth\Register;
use App\Filament\Pages\Biodata;
use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

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
        Livewire::component('app.filament.auth.register', Register::class);
        Filament::registerPages([
            Biodata::class,
        ]);
    }
}
