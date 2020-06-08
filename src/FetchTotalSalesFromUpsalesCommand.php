<?php

namespace Robbens\UpsalesTile;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Robbens\UpsalesTile\Services\UpsalesApi;

class FetchTotalSalesFromUpsalesCommand extends Command
{
    protected $signature = 'dashboard:fetch-total-sales-for-upsales';

    protected $description = 'Fetch the total sales for Upsales tile';

    public function handle()
    {
        $this->info('Fetching Upsales data...');

        $upsalesApi = app(UpsalesApi::class);
        $date = config('dashboard.tiles.upsales.total-sales.from-date');

        if (is_numeric($date)) {
            $date = Carbon::now()->subDays($date);
        }

        $response = $upsalesApi->orders([
            'closeDate' => 'gte:'.$date->format('Y-m-d'),
            'limit' => 500,
        ]);

        UpsalesStore::make('total-sales')->setData($response['data']);

        $this->info('All done!');
    }
}
