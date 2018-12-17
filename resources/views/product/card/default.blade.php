<div class="card mx-auto item m-2 shadow p-1" style="height: 95%;">
    <div class="bg-white card-img-top p-2">
        <div class=""
             style="height: 200px; background-image: url('{{$product->filename}}'); background-size: contain; background-position: center; background-repeat: no-repeat"></div>
    </div>
    <a href="/product/{{$product->id}}/" class="btn btn-dark goto text-white">
        <i class="fas fa-search"></i>
    </a>
    <div class="card-body">
        <h6 class="card-title text-center truncate">{{$product->title}}</h6>
        <hr class="mt-1 mb-3">
        <div class="row mb-2">
            <span class="col-6 text-center">€{{$product->selling_price}}</span>
            <span class="col-6 text-center">
                <product-card-timer end="{{$product->end}}"></product-card-timer>
            </span>
        </div>
        <div class="row">
            <div class="d-flex">
                @for($i = 1, $x = ($buttons +1); $i < $x; $i++)
                    <form action="{{ route('bid.create') }}" method="post">
                        @php $price = (getMinimalTopUp($product->selling_price) * $i) @endphp
                        {{ csrf_field() }}
                        <input type="hidden" name="product" value="{{ $product->id }}">
                        <input type="hidden" name="price" value="{{ $product->selling_price + $price }}">
                        <button class="btn btn-primary text-white" type="submit">
                            +
                            €{{ $price }}
                        </button>
                    </form>
                @endfor
            </div>
        </div>
    </div>
</div>
