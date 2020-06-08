<?php

namespace Robbens\UpsalesTile;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Livewire\Component;
use Robbens\UpsalesTile\Services\UpsalesApi;

class TotalSalesTileComponent extends Component
{
    public string $position;

    public function mount(string $position)
    {
        $this->position = $position;
    }

    public function days()
    {
        $fromDate = config('dashboard.tiles.upsales.total-sales.from-date');

        if (is_numeric($fromDate)) {
            return $fromDate;
        }

        if ($fromDate instanceof Carbon) {
            return $fromDate->diffInDays();
        }

        throw new \Exception('Value for from-date is invalid. Must be an integer or instance of Carbon');
    }

    public function render() : View
    {
        $data = UpsalesStore::make('total-sales')->getData();

        return view('dashboard-upsales-tile::total-sales', [
            'totalValueSum' => $data->sum('value'),
        ]);
    }
}
