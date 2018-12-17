@extends('layouts.app')

@section('content')
    <div class="rubriek-container">
        <h2 class="text-dark">{{$sidebar['current'][0]->name}}</h2>
        @include("components.product_view_deep")
        @include("rubrieken.components.rubrieken_sidebar")
    </div>
@endsection
