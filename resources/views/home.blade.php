@extends('layouts.app')

@section('content')

        @if (Auth::guest())
            @include("registratie-banner")
        @else
            @include("title-banner")
        @endif
        @include("components.product_view")
@endsection
