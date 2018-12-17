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
            <div class="btn-group m-0 mx-auto rounded" style="width: 90%;">
                @for($i = 1, $x = ($buttons +1); $i < $x; $i++)
                    <a class="btn btn-primary text-white align-items-center px-4"
                       style="width: {{ 100 / $buttons }}%">+ €{{ (getMinimalTopUp($product->selling_price) * $i) }}</a>
                @endfor
            </div>
        </div>
    </div>
</div>
