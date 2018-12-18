<div class="d-flex w-100 bids-buttons">
    @for($i = 1, $x = ($buttons +1); $i < $x; $i++)
        <form action="{{ route('bid.create') }}" method="post" class="flex-fill">
            @php
                $price = (getMinimalTopUp($product->selling_price) * $i);
                $total = $product->selling_price + $price;
            @endphp
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
