@extends('layouts.app')

@section('content')
        <div class="row mt-3">
            <div class="col mb-3">
                <h1>EenmaalAndermaal</h1>
            </div>
        </div>
        @if (Auth::guest())
            @include("registratie-banner")
        @endif
        @include("components.product_view")
@endsection
