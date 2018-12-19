@if(!empty($popular_products))
    <div class="row">
        <div class="col my-3">
            <h2>Populaire veilingen</h2>
            <hr/>
        </div>
    </div>
    <div class="row mb-4">
        @foreach($popular_products as $product)
            <div class="col-lg-4 col-md-4 col-12-sm col-12-xs">
                @include('product.card.default', array('buttons' => 3))
            </div>
        @endforeach
    </div>
@endif
@if(!empty($fast_ending_products))
    <div class="row">
        <div class="col my-3">
            <h3>Snel aflopende veilingen</h3>
            <hr/>
        </div>
    </div>
    <div class="row mb-4">
        @foreach($fast_ending_products as $product)
            <div class="col-lg-3 col-md-3 col-12-sm col-12-xs">
                @include('product.card.default', array('buttons' => 2))
            </div>
        @endforeach
    </div>
@endif

