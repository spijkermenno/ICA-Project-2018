@extends('layouts.app')

@section('content')
    <div class="rubriek-container">
        <div class="row">
            <div class="col mb-3">
                <h1>{{ $sidebar['current'][0]->name }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <h3>Populair</h3>
            </div>
        </div>
        <div class="row mb-4">
            @for ($i = 0; $i < 3; $i++)
                <div class="col">
                    @component('product.card')
                    @endcomponent
                </div>
            @endfor
        </div>
        <div class="row">
            <div class="col mb-3">
                <h3>Gauw voorbij!</h3>
            </div>
        </div>
        @for ($i = 0; $i < 3; $i++)
            <div class="row mb-4">
                @for ($j = 0; $j < 4; $j++)
                    <div class="col">
                        @component('product.card')
                        @endcomponent
                    </div>
                @endfor
            </div>
        @endfor
        <div class="sidebar card">
            <div class="card-body">
                <h3>Rubrieken</h3>
                <div class="sidebar-menu">
                    <a href="/rubrieken/"><strong>Alle</strong></a>
                    @foreach($sidebar['parents'] as $parent)
                    <ul>
                        <li><a href="/rubriek/{{ $parent->id }}">{{ $parent->name }}</a></li>
                    @endforeach
                        <ul>
                            <li><strong>{{ $sidebar['current'][0]->name }}</strong></li>
                            <ul>
                                @foreach($sidebar['children'] as $child)
                                    <li><a href="/rubriek/{{ $child->id }}">{{ $child->name }}</a></li>
                                @endforeach
                            </ul>
                        </ul>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
