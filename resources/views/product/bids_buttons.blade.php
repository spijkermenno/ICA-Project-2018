@php
    $current_date = \Illuminate\Support\Carbon::now();
    $start_date = \Illuminate\Support\Carbon::parse($product->start);
    $end_date = \Illuminate\Support\Carbon::parse($product->end);
@endphp

@if($current_date > $start_date && $current_date < $end_date)
    <div class="d-flex w-100 bids-buttons">
        @for($i = 1, $x = ($buttons +1); $i < $x; $i++)
            @php
                $price = (getMinimalTopUp($product->selling_price) * $i);
                $total = $product->selling_price + $price;
            @endphp
            <form action="{{ route('bid.create') }}" method="post" class="flex-fill">
                {{ csrf_field() }}
                <input type="hidden" name="product" value="{{ $product->id }}">
                <input type="hidden" name="price" value="{{ $product->selling_price + $price }}">
                <button class="btn btn-primary text-white w-100" type="submit" data-toggle="tooltip" data-placement="bottom" title="€{{ $total }}">
                    +
                    €{{ $price }}
                </button>
            </form>
        @endfor
    </div>
@else
    <div>
        <p class="p-0 m-0">
            @if($current_date > $end_date)
                {{ ucfirst($end_date->diffForHumans(null, null, false, 2)) }}
            @else
                {{ ucfirst($start_date->diffForHumans(null, null, false, 2)) }}
            @endif
        </p>
    </div>
@endif

