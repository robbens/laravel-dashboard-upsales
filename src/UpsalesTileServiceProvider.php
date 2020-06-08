<?php

namespace Robbens\UpsalesTile;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Robbens\UpsalesTile\Services\UpsalesApi;

class UpsalesTileServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FetchLatestSalesFromUpsalesCommand::class,
                FetchTotalSalesFromUpsalesCommand::class,
            ]);
        }

        if (! config('dashboard.tiles.upsales.token')) {
            throw new \Exception('Upsales API token is missing.');
        }

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/dashboard-upsales-tile'),
        ], 'dashboard-upsales-tile-views');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'dashboard-upsales-tile');

        Livewire::component('upsales-total-sales-tile', TotalSalesTileComponent::class);
        Livewire::component('upsales-latest-sales-tile', LatestSalesTileComponent::class);
    }

    public function register()
    {
        $this->app->singleton(UpsalesApi::class, function () {
            return new UpsalesApi(config('dashboard.tiles.upsales.token'));
        });
    }
}
