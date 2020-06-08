<?php

namespace Robbens\UpsalesTile;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Robbens\UpsalesTile\Services\UpsalesApi;

class FetchLatestSalesFromUpsalesCommand extends Command
{
    protected $signature = 'dashboard:fetch-latest-sales-for-upsales';

    protected $description = 'Fetch the latest sales for Upsales tile';

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

        UpsalesStore::make('latest-sales')->setData($response['data']);

        $this->info('All done!');
    }
}
