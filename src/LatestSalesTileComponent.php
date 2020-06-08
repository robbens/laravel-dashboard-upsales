<?php

namespace Robbens\UpsalesTile;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Livewire\Component;
use Robbens\UpsalesTile\Services\UpsalesApi;

class LatestSalesTileComponent extends Component
{
    public string $position;
    public string $limit;

    public function mount(string $position, $limit = '5')
    {
        $this->position = $position;
        $this->limit = $limit;
    }

    public function render() : View
    {
        $data = UpsalesStore::make('latest-sales')->getData();

        // Sort by closeDate
        $data = $data->sort(function ($a, $b) {
            return strtotime($a['closeDate']) < strtotime($b['closeDate']);
        });

        return view('dashboard-upsales-tile::latest-sales', [
            'latestSales' => $data->take($this->limit),
        ]);
    }
}
