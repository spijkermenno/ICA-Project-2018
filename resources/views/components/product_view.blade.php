<div class="row">
    <div class="col mb-3">
        <h3>Populair</h3>
    </div>
</div>
<div class="row mb-4">
    @foreach($popular_products as $product)
        <div class="col-lg-4 col-md-4 col-12-sm col-12-xs">
            @include('product.card.default')
        </div>
    @endforeach
</div>
<div class="row">
    <div class="col mb-3">
        <h3>Gauw voorbij!</h3>
    </div>
</div>
<div class="row mb-4">
    @foreach($fast_ending_products as $product)
        <div class="col-lg-3 col-md-3 col-12-sm col-12-xs">
            @include('product.card.default')
        </div>
    @endforeach
</div>

