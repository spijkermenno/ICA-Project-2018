@extends('layouts.app')

@section('content')

        @if (Auth::guest())
            @include("registratie-banner")
        @else
            @component("components.title-banner")
                EenmaalAndermaal
            @endcomponent
        @endif
        @include("components.product_view")
@endsection
