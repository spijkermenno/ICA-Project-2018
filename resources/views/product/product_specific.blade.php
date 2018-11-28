@extends('layouts.app')

@section('content')
    <div class="container mb-3">
        @include("breadcrumbs")

        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-12 border bg-dark">
                @include('carousel')
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="row">
                    <div class="col-12">
                        <h1> {{$product['title']}}</h1>
                    </div>
                    <div class="col-12 text-justify">
                        <p> {{$product['description']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                @include('bids')
            </div>
        </div>
    </div>
@endsection
