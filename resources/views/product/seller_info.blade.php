<div class="col-12 p-lg-1 p-md-1 pt-2 text-center">
    <h5 class="pb-1">{{$product->seller}}</h5>
    <h5 class="pb-1">{{$product->country}} | {{$product->city}}</h5>
    <h5 class="pb-1">Verzendkosten: € {{ priceFormat($product->shipping_cost) }}</h5>
</div>
