    <div class="col-lg-3 col-md-4 col-sm-12">
    <div id="biedingen">
        <div class="card">
            <div class="card-header p-0 m-0 bg-success text-white" id="headingOne">
                <div class="row  p-1 pt-2 pl-2 position-relative" data-toggle="collapse" data-target="#biedinglijst">
                    <h5 class="col-9 col-md-8 col-lg-8">{{$bids[0]["user"]}}</h5>
                    <h5 class="col-3 col-md-4 col-lg-4 badge badge-secondary" style="min-width: 40px; max-width: 60px; line-height: 15px">€{{$bids[0]["amount"]}}</h5>
                </div>
            </div>

            <div id="biedinglijst" class="collapse show" data-parent="#biedingen">
                <div class="card-body p-0 bg-white overflow-hide-y border-bottom overflow-hide-x" style="max-height: 210px">
                    @foreach ($bids as $bid)
                        @if($bid['amount'] != $bids[0]["amount"])
                            <div class="row p-1 pt-2 pl-2 border-bottom">
                                <h5 class="col-9 col-md-8 col-lg-8">{{$bid["user"]}}</h5>
                                <h5 class="col-3 col-md-4 col-lg-4 badge badge-secondary" style="min-width: 40px; max-width: 60px; line-height: 15px">€{{$bid["amount"]}}</h5>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="card-header p-0">
                <div class="row p-1 pl-2">
                <h5 class="col-9 col-md-8 col-lg-8 font-weight-bold">Start bod</h5>
                    <h5 class="col-3 col-md-4 col-lg-4 badge badge-secondary" style="min-width: 40px; max-width: 60px; line-height: 15px">€{{$product["start_bid"]}}</h5>
                </div>
            </div>
            <div class="card-body p-2 position-relative">
                <div class="btn-group" role="group" style="width: 100%">
                    <button type="button" class="btn btn-outline-dark w-50" {{auth()->check() ? '': 'disabled'}}>€5
                    </button>
                    <button type="button" class="btn btn-outline-dark w-50" {{auth()->check() ? '': 'disabled'}}>€10
                    </button>
                    <button type="button" class="btn btn-outline-dark w-50" {{auth()->check() ? '': 'disabled'}}>€20
                    </button>
                    <button type="button" class="btn btn-outline-dark w-50" {{auth()->check() ? '': 'disabled'}}>€50
                    </button>
                </div>

            </div>
        </div>
    </div>
        <div id="betaalmiddel">
            <span class="d-block text-center far fa-card">((Font Awesome icon))</span>
            <h5>
                Betaling via {{$product['payment_type']}}
            </h5>
            <h5>{{$product['payment_time']}}</h5>
        </div>
</div>
