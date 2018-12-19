@extends('layouts.app')

@section('content')
    @if(session('successful_bid'))
        <div class="alert alert-primary alert-dismissible mt-4 mb-4" role="alert">
            U heeft succesvol een bod van &euro;{{ session('successful_bid')['price'] }} uitgebracht op deze veiling
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('error_bid'))
        <div class="alert alert-warning alert-dismissible mt-4 mb-4" role="alert">
            {{ session('error_bid')['message'] }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row" id="wrapper">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="row">
                @include('product.carousel')
                @include('product.seller_info')
                @include('product.calender')
            </div>
        </div>
        @include('product.product_info')
        @include('product.bids')
    </div>
@endsection
