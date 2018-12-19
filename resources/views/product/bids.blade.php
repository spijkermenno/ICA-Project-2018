

<div class="col-lg-3 col-md-4 col-sm-12">
    <div id="biedingen">
        <h4>
            <span class="text-primary">Tijd resterend</span>
            <product-card-timer end="{{ $product->end }}"></product-card-timer>
        </h4>
        <div class="card">
            <div class="card-header p-0 m-0 bg-primary text-white" id="headingOne">
                <div class="row pt-2 pl-2 position-relative" data-toggle="collapse" data-target="#biedinglijst">
                    <div class="col-8 col-md-8 col-lg-8"
                        style="font-size:20px;">
                        @if($bids[0]->date == "")
                            Geen biedingen
                        @else
                            {{ $bids[0]->user_name }}
                        @endif
                    </div>
                    @if($product->start_price != $bids[0]->highest_bid)
                        <div class="col-4 col-md-4 col-lg-4 badge badge-secondary"
                            style="min-width: 40px; max-width: 60px; line-height: 15px; max-height: 22px; margin-top: 8px;">
                                €{{$bids[0]->highest_bid}}
                        </div>
                    @endif
                </div>
                <div class="row pr-1 pt-0 pl-2">
                    <h6 class="col-12 col-md-12 col-lg-12">
                        @if($bids[0]->date != "")
                            {{ \Illuminate\Support\Carbon::parse($bids[0]->date)->diffForHumans() }}
                        @endif
                    </h6>
                </div>
            </div>

            <div id="biedinglijst" class="collapse show" data-parent="#biedingen">
                <div class="card-body p-0 bg-white overflow-hide-y border-bottom overflow-hide-x">
                    @foreach ($bids as $bid)
                        @if($bid->highest_bid != $bids[0]->highest_bid)
                            <div class="row pt-2 pl-2">
                                <div class="col-8 col-md-8 col-lg-8">{{$bid->user_name}}</div>
                                <div class="col-4 col-md-4 col-lg-4 badge badge-secondary"
                                    style="min-width: 40px; max-width: 60px; line-height: 15px">€{{$bid->highest_bid}}</div>
                            </div>
                            <div class="row pr-1 pt-0 pl-2 border-bottom">
                                <h6 class="col-12 col-md-12 col-lg-12">{{ \Illuminate\Support\Carbon::parse($bid->date)->diffForHumans() }}</h6>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="card-header p-0">
                <div class="row p-1 pl-2">
                    <h5 class="col-9 col-md-8 col-lg-8 font-weight-bold">Start bod</h5>
                    <h5 class="col-3 col-md-4 col-lg-4 badge badge-secondary"
                        style="min-width: 40px; max-width: 60px; line-height: 15px">€{{$product->start_price}}</h5>
                </div>
            </div>
            <div class="card-body p-2 position-relative">
                @include('product.bids_buttons', ['buttons' => 3])
            </div>
        </div>
    </div>
    <div id="betaalmiddel" class="text-center">
        <h5>
            Betaling via {{$product->payment_method}}
        </h5>
        <h5>{{$product->payment_instruction}}</h5>
    </div>
</div>
