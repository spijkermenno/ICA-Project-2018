@extends('layouts.app')

@section('content')
    <div id="top"></div>
    <div class="container rubrieken_pagina">
        <h1>Rubrieken</h1>
        <div class="alphabet sticky-top">
            <ul>
                @foreach($alphabet as $item)
                    @if($item['active'] == true)
                        <li><a class="text-dark" href="#{{ $item['letter'] }}">{{ $item['letter'] }}</a></li>
                    @else
                        <li class="inactive">{{ $item['letter'] }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="categories">
            <ul class="category_parents">
                @foreach($parents as $parent)
                    <li class="parent" id="{{ $parent->name[0] }}"><a class="text-dark" href="/rubriek/{{ $parent->id }}/{{ str_replace(" ", "-", $parent->name) }}">{{ $parent->name }}</a>
                        <ul class="category_children">
                            @foreach($parent->children as $child)
                                @if($child->parent == $parent->id)
                                    <li><a class="text-dark" href="/rubriek/{{ $child->id }}">{{ $child->name }}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(".alphabet ul li a[href^='#']").on('click', function(e) {

            // prevent default anchor click behavior
            e.preventDefault();

            // store hash
            var hash = this.hash;

            // animate
            $('html, body').animate({
                scrollTop: $(hash).offset().top-$('.alphabet').height()
            },500);
        });
    </script>
@endpush
