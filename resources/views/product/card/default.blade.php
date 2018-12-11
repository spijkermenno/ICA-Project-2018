<div class="card mx-auto item m-2 shadow">
    <img class="card-img-top" src="http://cafard-na-home.fr/temp-img/tv-test-pattern%20-%20copie.jpg"
         alt="{{$product['title']}}">
    <a href="#" class="btn btn-dark goto text-white">
        <i class="fas fa-angle-right"></i>
    </a>
    <div class="card-body">
        <h4 class="card-title text-center">{{$product['title']}}</h4>
        <hr class="mt-1 mb-3">
        <div class="row mb-2">
            <span class="col-6 text-center">€{{$product['selling_price']}}</span>
            <span class="col-6 text-danger text-center">{{$product['time_left']}}</span>
        </div>
        <div class="row">
            <div class="btn-group m-0 mx-auto rounded" style="width: 90%;">
                @for($i = 1, $x = ($product['buttons'] +1); $i < $x; $i++)
                    <a class="btn btn-primary text-white align-items-center px-4" style="width: {{ 100 / $product['buttons'] }}%">€{{ ($product['minimale_verhoging'] * $i) }}</a>
                @endfor
            </div>
        </div>
    </div>
</div>
