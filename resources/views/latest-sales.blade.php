@inject('carbon', 'Carbon\Carbon')
@inject('currency', 'Robbens\UpsalesTile\Currency')

<x-dashboard-tile :position="$position" refresh-interval="10">
    <div class="table w-full">
        @foreach($latestSales as $sale)
            <div class="table-row">
                <div class="table-cell py-2 border-b whitespace-no-wrap pr-5">
                    {{ $carbon->make($sale['closeDate'])->diffForHumans() }}
                </div>

                <div class="table-cell py-2 border-b">
                    {{ $sale['user']['name'] }} sold {{ $sale['description'] }} to {{ $sale['client']['name'] }}
                </div>

                <div class="table-cell py-2 border-b text-right">
                    {{ $currency->format($sale['value']) }}
                </div>
            </div>
        @endforeach
    </div>
</x-dashboard-tile>
