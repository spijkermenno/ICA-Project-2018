@extends('layouts.app')

@section('content')
    <div class="container">
        @include("breadcrumbs")
        <div class="row">
            <div class="col mb-3">
                <h1>Populair</h1>
            </div>
        </div>
        <div class="row mb-5">
            {{-- @foreach ($popularProducts as $popularProduct)
                <div class="col">
                    @component('product.card')
                    @endcomponent
                </div>
            @endforeach --}}
            @for ($i = 0; $i < 3; $i++)
                <div class="col">
                    @component('product.card')
                    @endcomponent
                </div>
            @endfor
        </div>
        <div class="row">
            <div class="col mb-3">
                <h1>Gauw voorbij!</h1>
            </div>
        </div>
        @for ($i = 0; $i < 3; $i++)
            <div class="row mb-5">
                @for ($j = 0; $j < 4; $j++)
                    <div class="col">
                    @component('product.card')
                    @endcomponent
                    </div>
                @endfor
            </div>
        @endfor
    </div>
@endsection
