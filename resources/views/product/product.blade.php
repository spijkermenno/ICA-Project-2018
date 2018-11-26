@extends('layouts.app')

@section('content')
    <div class="container">
        @include("breadcrumbs")

        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-12 border bg-light"
                 style="background: url('{{$product['image'][0]}}');background-size: contain;background-position: center;background-repeat: no-repeat;height: 400px;">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="row">
                    <div class="col-12">
                        <h1> {{$product['title']}}</h1>
                    </div>
                    <div class="col-12">
                        <p> {{$product['description']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="" id="biedingen">
                    <div class="card">
                        <div class="card-header m-0" id="headingOne">
                            <p class="text-center m-0" data-toggle="collapse" data-target="#biedinglijst">
                                Biedingen
                            </p>
                        </div>

                        <div id="biedinglijst" class="collapse show" data-parent="#biedingen">
                            <div class="card-body p-2">
                                @foreach ($bids as $bid)
                                    <div class="w-100">
                                        <h5 class="w-75 d-inline-block">{{$bid["user"]}}</h5>
                                        <h5 class="d-inline-block badge badge-secondary">€{{$bid["amount"]}}</h5>
                                    </div>
                                    <hr>
                                @endforeach
                                    <div class="w-100">
                                        <h5 class="w-75 d-inline-block font-weight-bold">Start bod</h5>
                                        <h5 class="d-inline-block badge badge-secondary">€{{$product["start_bid"]}}</h5>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
