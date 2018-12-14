@extends('layouts.app')

@section('content')
    <div class="rubriek-container">
        @include("components.product_view")

        @include("rubrieken.components.rubrieken_sidebar")
    </div>
@endsection
