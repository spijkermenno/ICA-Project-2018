<div class="col-12 border bg-dark">
    <div id="carousel-product" class="carousel slide w-100" data-ride="carousel" data-interval="false"
         style="height: 395px">
        <ol class="carousel-indicators">
            @for($i = 0, $x = count($images); $i < $x; $i++)
                @if($i == 0)
                    <li data-target="#carousel-product" data-slide-to="{{$i}}" class="active" style="text-shadow: black 0px 0px 5px;">
                @else
                    <li data-target="#carousel-product" data-slide-to="{{$i}}" style="text-shadow: black 0px 0px 5px;">
                @endif

            @endfor
        </ol>
        <div class="carousel-inner">
            @for($i = 0, $x = count($images); $i < $x; $i++)
                @if($i == 0)
                    <div class="carousel-item active" style="height: 395px; background-image: url('{{$images[$i]->filename}}'); background-size: contain; background-position: center; background-repeat: no-repeat"></div>
                @else
                    <div class="carousel-item" style="height: 395px; background-image: url('{{$images[$i]->filename}}'); background-size: contain; background-position: center; background-repeat: no-repeat"></div>

                @endif
            @endfor
        </div>
        <a class="carousel-control-prev text-white" href="#carousel-product" role="button" data-slide="prev" style="text-shadow: black 0px 0px 5px;">
            <i class="fas fa-chevron-left fa-2x"></i>
        </a>
        <a class="carousel-control-next text-white" href="#carousel-product" role="button" data-slide="next" style="text-shadow: black 0px 0px 5px;">
            <i class="fas fa-chevron-right fa-2x"></i>
        </a>
    </div>
</div>
