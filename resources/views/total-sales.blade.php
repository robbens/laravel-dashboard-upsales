@inject('currency', 'Robbens\UpsalesTile\Currency')

<x-dashboard-tile :position="$position" refresh-interval="10">
    <div class="flex h-full justify-center text-center">
        <div class="self-center">
            <h2 class="text-2xl tracking-wide">Total sales</h2>

            <h2 class="font-bold text-6xl tracking-wide leading-none my-3">
                {{ $currency->format($totalValueSum) }}
            </h2>

            <div>
                last {{ $this->days() }} days
            </div>
        </div>
    </div>
</x-dashboard-tile>
