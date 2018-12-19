@extends('layouts.app')

@section('content')
    @component("components.title-banner")
        Zoekresultaten voor <br/>
        '{{ $searchQuery }}'
    @endcomponent
    <div class="row mb-4">
    @foreach($products as $product)
        <div class="col-lg-3 col-md-4 col-sm-12">
            @include('product.card.default')
        </div>
    @endforeach
    </div>

    <div class="row mb-4">
        @if($products instanceof Illuminate\Pagination\LengthAwarePaginator)
            {{ $products->links() }}
        @endif
    <div>
@endsection
