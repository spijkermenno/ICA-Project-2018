@extends('layouts.app')

@section('content')
    @component("components.title-banner")
        Mijn veilingen
    @endcomponent

    @if($openVeilingen)
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
            @foreach($openVeilingen as $openVeiling)
                <div class="row">
                    <div class="col-md-1 border">
                        <a href="{{route('product_no_name', ['product' => $openVeiling->id])}}"><img style="width: 100%;" class="p-1" src="{{ $openVeiling->image }}" /></a>
                    </div>
                    <div class="col-md-5 border">
                        <a href="{{route('product_no_name', ['product' => $openVeiling->id])}}">{{ $openVeiling->title }}</a>
                    </div>
                    <div class="col-md-3 border">
                        @if(!$openVeiling->highestBid)
                            Er zijn geen biedingen
                        @else
                            €{{ $openVeiling->selling_price }}
                        @endif                    </div>
                    <div class="col-md-3 border">
                        <product-card-timer end="{{ $openVeiling->end }}"></product-card-timer>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($geslotenVeilingen)
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
            @foreach($geslotenVeilingen as $geslotenVeiling)
                <div class="row">
                    <div class="col-md-1 border">
                        <a href="{{route('product_no_name', ['product' => $geslotenVeiling->id])}}"><img style="width: 100%;" class="p-1" src="{{ $geslotenVeiling->image }}" /></a>
                    </div>
                    <div class="col-md-5 border">
                        <a href="{{route('product_no_name', ['product' => $geslotenVeiling->id])}}">{{ $geslotenVeiling->title }}</a>
                    </div>
                    <div class="col-md-2 border">
                        @if(!$geslotenVeiling->highestBid)
                            Er zijn geen biedingen
                        @else
                            €{{ $geslotenVeiling->selling_price }}
                        @endif
                    </div>
                    <div class="col-md-2 border">
                        @if($geslotenVeiling->buyer != '')
                            {{ $geslotenVeiling->buyer }}
                        @else
                            Er is geen koper
                        @endif
                    </div>
                    <div class="col-md-2 border">
                        {{ $geslotenVeiling->end }}
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    @endif

    @if(!$geslotenVeilingen && !$openVeilingen)
        <h3 class="font-weight-light text-dark mt-2 text-center">Er zijn nog geen veilingen geplaatst.</h3>
    @endif

@endsection
