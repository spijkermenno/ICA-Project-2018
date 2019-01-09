@extends('layouts.app')

@section('content')
    @component("components.title-banner")
        Mijn biedingen
    @endcomponent

    @if($overbodenVeilingen)
        <div class="p-2 mt-3 mb-0 b border-0 rounded-0">
            <h2>Lopende veilingen</h2>
            <div class="row">
                <div class="col-md-1 border font-weight-bold">

                </div>
                <div class="col-md-5 border font-weight-bold">
                    Titel
                </div>
                <div class="col-md-3 border font-weight-bold">
                    Hoogste bod
                </div>
                <div class="col-md-3 border font-weight-bold">
                    Resterende tijd
                </div>
            </div>
            @foreach($overbodenVeilingen as $overbodenVeiling)
                <div class="row">
                    <div class="col-md-1 border">
                        <a href="{{route('product_no_name', ['product' => $overbodenVeiling->id])}}"><img style="width: 100%;" class="p-1" src="{{ $overbodenVeiling->image }}" /></a>
                    </div>
                    <div class="col-md-5 border">
                        <a href="{{route('product_no_name', ['product' => $overbodenVeiling->id])}}">{{ $overbodenVeiling->title }}</a>
                    </div>
                    <div class="col-md-3 border">
                        @if(!$overbodenVeiling->highestBid)
                            Er zijn geen biedingen
                        @else
                            €{{ $overbodenVeiling->selling_price }}
                        @endif                    </div>
                    <div class="col-md-3 border">
                        <product-card-timer end="{{ $overbodenVeiling->end }}"></product-card-timer>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($hoogsteGebodenVeilingen)
        <div class="p-2 mt-3 mb-0 b border-0 rounded-0">
            <h2>Lopende veilingen</h2>
            <div class="row">
                <div class="col-md-1 border font-weight-bold">

                </div>
                <div class="col-md-5 border font-weight-bold">
                    Titel
                </div>
                <div class="col-md-3 border font-weight-bold">
                    Hoogste bod
                </div>
                <div class="col-md-3 border font-weight-bold">
                    Resterende tijd
                </div>
            </div>
            @foreach($hoogsteGebodenVeilingen as $hoogsteGebodenVeiling)
                <div class="row">
                    <div class="col-md-1 border">
                        <a href="{{route('product_no_name', ['product' => $hoogsteGebodenVeiling->id])}}"><img style="width: 100%;" class="p-1" src="{{ $hoogsteGebodenVeiling->image }}" /></a>
                    </div>
                    <div class="col-md-5 border">
                        <a href="{{route('product_no_name', ['product' => $hoogsteGebodenVeiling->id])}}">{{ $hoogsteGebodenVeiling->title }}</a>
                    </div>
                    <div class="col-md-3 border">
                        @if(!$hoogsteGebodenVeiling->highestBid)
                            Er zijn geen biedingen
                        @else
                            €{{ $hoogsteGebodenVeiling->selling_price }}
                        @endif                    </div>
                    <div class="col-md-3 border">
                        <product-card-timer end="{{ $hoogsteGebodenVeiling->end }}"></product-card-timer>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($gewonnenVeilingen)
        <div class="p-2 mt-3 mb-0 b border-0 rounded-0">
            <h2>Verlopen veilingen</h2>
            <div class="row">
                <div class="col-md-1 border">

                </div>
                <div class="col-md-5 border font-weight-bold">
                    Titel
                </div>
                <div class="col-md-2 border font-weight-bold">
                    Hoogste bod
                </div>
                <div class="col-md-2 border font-weight-bold">
                    Koper
                </div>
                <div class="col-md-2 border font-weight-bold">
                    Afloopdatum
                </div>
            </div>
            @foreach($gewonnenVeilingen as $gewonnenVeiling)
                <div class="row">
                    <div class="col-md-1 border">
                        <a href="{{route('product_no_name', ['product' => $gewonnenVeiling->id])}}"><img style="width: 100%;" class="p-1" src="{{ $gewonnenVeiling->image }}" /></a>
                    </div>
                    <div class="col-md-5 border">
                        <a href="{{route('product_no_name', ['product' => $gewonnenVeiling->id])}}">{{ $gewonnenVeiling->title }}</a>
                    </div>
                    <div class="col-md-2 border">
                        @if(!$gewonnenVeiling->highestBid)
                            Er zijn geen biedingen
                        @else
                            €{{ $gewonnenVeiling->selling_price }}
                        @endif
                    </div>
                    <div class="col-md-2 border">
                        @if($gewonnenVeiling->buyer != '')
                            {{ $gewonnenVeiling->buyer }}
                        @else
                            Er is geen koper
                        @endif
                    </div>
                    <div class="col-md-2 border">
                        {{ $gewonnenVeiling->end }}
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    @endif

    @if($verlorenVeilingen)
        <div class="p-2 mt-3 mb-0 b border-0 rounded-0">
            <h2>Verlopen veilingen</h2>
            <div class="row">
                <div class="col-md-1 border">

                </div>
                <div class="col-md-5 border font-weight-bold">
                    Titel
                </div>
                <div class="col-md-2 border font-weight-bold">
                    Hoogste bod
                </div>
                <div class="col-md-2 border font-weight-bold">
                    Koper
                </div>
                <div class="col-md-2 border font-weight-bold">
                    Afloopdatum
                </div>
            </div>
            @foreach($verlorenVeilingen as $verlorenVeiling)
                <div class="row">
                    <div class="col-md-1 border">
                        <a href="{{route('product_no_name', ['product' => $verlorenVeiling->id])}}"><img style="width: 100%;" class="p-1" src="{{ $verlorenVeiling->image }}" /></a>
                    </div>
                    <div class="col-md-5 border">
                        <a href="{{route('product_no_name', ['product' => $verlorenVeiling->id])}}">{{ $verlorenVeiling->title }}</a>
                    </div>
                    <div class="col-md-2 border">
                        @if(!$verlorenVeiling->highestBid)
                            Er zijn geen biedingen
                        @else
                            €{{ $verlorenVeiling->selling_price }}
                        @endif
                    </div>
                    <div class="col-md-2 border">
                        @if($verlorenVeiling->buyer != '')
                            {{ $verlorenVeiling->buyer }}
                        @else
                            Er is geen koper
                        @endif
                    </div>
                    <div class="col-md-2 border">
                        {{ $verlorenVeiling->end }}
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    @endif

    @if(!$overbodenVeilingen && !$hoogsteGebodenVeilingen && !$gewonnenVeilingen && !$verlorenVeilingen)
        <h3 class="font-weight-light text-dark mt-2 text-center">Er zijn nog geen biedingen geplaatst.</h3>
    @endif

@endsection
