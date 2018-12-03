<div class="col-12 border bg-dark">
    <div id="carousel-product" class="carousel slide w-100" data-ride="carousel" data-interval="false"
         style="height: 395px">
        <ol class="carousel-indicators">
            @for($i = 0, $x = count($product['image']); $i < $x; $i++)
                @if($i == 0)
                    <li data-target="#carousel-product" data-slide-to="{{$i}}" class="active">
                @else
                    <li data-target="#carousel-product" data-slide-to="{{$i}}">
                @endif

            @endfor
        </ol>
        <div class="carousel-inner">
            @for($i = 0, $x = count($product['image']); $i < $x; $i++)
                @if($i == 0)
                    <div class="carousel-item active" style="height: 395px; background-image: url('{{$product['image'][$i]['link']}}'); background-size: contain; background-position: center; background-repeat: no-repeat"></div>
                @else
                    <div class="carousel-item" style="height: 395px; background-image: url('{{$product['image'][$i]['link']}}'); background-size: contain; background-position: center; background-repeat: no-repeat"></div>

                @endif
            @endfor
        </div>
        <a class="carousel-control-prev" href="#carousel-product" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#carousel-product" role="button" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>
</div>
