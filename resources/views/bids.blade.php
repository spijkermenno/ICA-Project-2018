<div class="" id="biedingen">
    <div class="card">
        <div class="card-header m-0 bg-success text-white" id="headingOne">
            <div class="m-0 p-0 mr-2" data-toggle="collapse" data-target="#biedinglijst">
                <h5 class="w-75 d-inline-block">{{$bids[0]["user"]}}</h5>
                <h5 class="d-inline-block badge badge-secondary p-1">€{{ priceFormat($bids[0]["amount"]) }}</h5>
            </div>
        </div>

        <div id="biedinglijst" class="collapse show" data-parent="#biedingen">
            <div class="card-body p-2 bg-light overflow-scroll border-bottom" style="max-height: 200px">
                @foreach ($bids as $bid)
                    @if($bid['amount'] != $bids[0]["amount"])
                    <div class="w-100 border-bottom p-1">
                        <h5 class="w-75 d-inline-block">{{$bid["user"]}}</h5>
                        <h5 class="d-inline-block badge badge-secondary p-1">€{{ priceFormat($bid["amount"]) }}</h5>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="card-body p-2 bg-light pr-4">
            <h5 class="w-75 d-inline-block font-weight-bold">Start bod</h5>
            <h5 class="d-inline-block badge badge-secondary p-1">€{{ priceFormat($product["start_bid"]) }}</h5>
        </div>
    </div>
</div>
