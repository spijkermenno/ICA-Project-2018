@if(count($products) > 0 )

<div class="row mb-4">
    @foreach($products as $product)
        <div class="col-lg-3 col-md-3 col-12-sm col-12-xs">
            @include('product.card.default', array('buttons' => 2))
        </div>
    @endforeach
</div>
@else
    <h2 class="mt-5 text-dark text-center">Deze rubriek heeft op dit moment geen veilingen</h2>
@endif
