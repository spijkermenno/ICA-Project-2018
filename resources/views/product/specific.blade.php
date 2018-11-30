@extends('layouts.app')

@section('content')
    <div class="container">
        @include("breadcrumbs")
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
    </div>
@endsection
