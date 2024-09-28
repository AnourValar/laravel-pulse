<?php

namespace AnourValar\LaravelPulse\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelPulseServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     * @psalm-suppress UndefinedClass
     */
    public function boot()
    {
        // views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'anourvalar.pulse');
        \Livewire::component('anourvalar.pulse.schedule', \AnourValar\LaravelPulse\Livewire\Schedule::class);
        \Livewire::component('anourvalar.pulse.http-requests-count', \AnourValar\LaravelPulse\Livewire\HttpRequestsCount::class);
        \Livewire::component('anourvalar.pulse.http-requests-avg', \AnourValar\LaravelPulse\Livewire\HttpRequestsAvg::class);
        \Livewire::component('anourvalar.pulse.database', \AnourValar\LaravelPulse\Livewire\Database::class);
    }
}
