@extends('layouts.app')

@section('content')
    @component("components.title-banner")
        Mijn biedingen
    @endcomponent

    @if($losingBids)
        <div class="p-2 mt-3 mb-0 b border-0 rounded-0">
            <h2>Overboden lopende veilingen</h2>
            <div class="row">
                <div class="col-md-1 border font-weight-bold">

                </div>
                <div class="col-md-5 border font-weight-bold">
                    Titel
                </div>
                <div class="col-md-2 border font-weight-bold">
                    Jouw bod
                </div>
                <div class="col-md-2 border font-weight-bold">
                    Hoogste bod
                </div>
                
                <div class="col-md-2 border font-weight-bold">
                    Resterende tijd
                </div>
            </div>
            @foreach($losingBids as $losingBid)
                <div class="row">
                    <div class="col-md-1 border">
                        <a href="{{route('product_no_name', ['product' => $losingBid->id])}}"><img style="width: 100%;" class="p-1" src="{{ $losingBid->image }}" /></a>
                    </div>
                    <div class="col-md-5 border">
                        <a href="{{route('product_no_name', ['product' => $losingBid->id])}}">{{ $losingBid->title }}</a>
                    </div>
                    <div class="col-md-2 border">
                        
                            €{{ $losingBid->user_bid }}
                          </div>
                          <div class="col-md-2 border">
                        
                            €{{ $losingBid->highest_bid }}
                          </div>
                    <div class="col-md-2 border">
                        <product-card-timer end="{{ $losingBid->end }}"></product-card-timer>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($winningBids)
    <div class="p-2 mt-3 mb-0 b border-0 rounded-0">
        <h2>Hoogst geboden lopende veilingen</h2>
        <div class="row">
            <div class="col-md-1 border font-weight-bold">

            </div>
            <div class="col-md-5 border font-weight-bold">
                Titel
            </div>
            <div class="col-md-3 border font-weight-bold">
                Bod
            </div>
            
            <div class="col-md-3 border font-weight-bold">
                Resterende tijd
            </div>
        </div>
        @foreach($winningBids as $winningBid)
            <div class="row">
                <div class="col-md-1 border">
                    <a href="{{route('product_no_name', ['product' => $winningBid->id])}}"><img style="width: 100%;" class="p-1" src="{{ $winningBid->image }}" /></a>
                </div>
                <div class="col-md-5 border">
                    <a href="{{route('product_no_name', ['product' => $winningBid->id])}}">{{ $winningBid->title }}</a>
                </div>
                <div class="col-md-3 border">
                    
                        €{{ $winningBid->user_bid }}
                      </div>
                <div class="col-md-3 border">
                    <product-card-timer end="{{ $winningBid->end }}"></product-card-timer>
                </div>
            </div>
        @endforeach
    </div>
    @endif

    

    @if($wonBids)
    <div class="p-2 mt-3 mb-0 b border-0 rounded-0">
        <h2>Gewonnen veilingen</h2>
        <div class="row">
            <div class="col-md-1 border font-weight-bold">

            </div>
            <div class="col-md-5 border font-weight-bold">
                Titel
            </div>
            <div class="col-md-2 border font-weight-bold">
                Jouw bod
            </div>
            <div class="col-md-2 border font-weight-bold">
                Verkoper
            </div>
            
            <div class="col-md-2 border font-weight-bold">
                Datum
            </div>
        </div>
        @foreach($wonBids as $wonBid)
            <div class="row">
                <div class="col-md-1 border">
                    <a href="{{route('product_no_name', ['product' => $wonBid->id])}}"><img style="width: 100%;" class="p-1" src="{{ $wonBid->image }}" /></a>
                </div>
                <div class="col-md-5 border">
                    <a href="{{route('product_no_name', ['product' => $wonBid->id])}}">{{ $wonBid->title }}</a>
                </div>
                <div class="col-md-2 border">
                    
                        €{{ $wonBid->user_bid }}
                      </div>
                      <div class="col-md-2 border">
                    
                        €{{ $wonBid->seller }}
                      </div>
                <div class="col-md-2 border">
                  {{ \Illuminate\Support\Carbon::parse($wonBid->end)->format('d-m-Y')  }}
                </div>
            </div>
        @endforeach
    </div>
    @endif

    @if($lostBids)
    <div class="p-2 mt-3 mb-0 b border-0 rounded-0">
        <h2>Verloren veilingen</h2>
        <div class="row">
            <div class="col-md-1 border font-weight-bold">

            </div>
            <div class="col-md-5 border font-weight-bold">
                Titel
            </div>
            <div class="col-md-2 border font-weight-bold">
                Jouw bod
            </div>
            <div class="col-md-2 border font-weight-bold">
                Hoogste bod
            </div>
            
            <div class="col-md-2 border font-weight-bold">
                Datum
            </div>
        </div>
        @foreach($lostBids as $lostBid)
            <div class="row">
                <div class="col-md-1 border">
                    <a href="{{route('product_no_name', ['product' => $lostBid->id])}}"><img style="width: 100%;" class="p-1" src="{{ $lostBid->image }}" /></a>
                </div>
                <div class="col-md-5 border">
                    <a href="{{route('product_no_name', ['product' => $lostBid->id])}}">{{ $lostBid->title }}</a>
                </div>
                <div class="col-md-2 border">
                    
                        €{{ $lostBid->user_bid }}
                      </div>
                      <div class="col-md-2 border">
                    
                        €{{ $lostBid->highest_bid }}
                      </div>
                <div class="col-md-2 border">
                    {{ $lostBid->end }}
                </div>
            </div>
        @endforeach
    </div>
    @endif

    @if(!$losingBids && !$winningBids && !$lostBids && !$wonBids)
        <h3 class="font-weight-light text-dark mt-2 text-center">Er zijn nog geen biedingen geplaatst.</h3>
    @endif

@endsection
