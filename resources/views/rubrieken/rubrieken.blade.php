@extends('layouts.app')

@section('content')
    <div id="top"></div>
    <div class="rubrieken_pagina">
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
                    <li class="parent" id="{{ $parent->name[0] }}"><a class="text-dark" href="/rubriek/{{ $parent->id }}/{{ str_slug($parent->name) }}">{{ $parent->name }}</a>
                        @if ($user = Auth::user())
                            <div class="parent-category-management">
                                <span class="badge badge-secondary" data-toggle="tooltip" data-placement="top" title="Volgnummer">{{ $parent->order_number }}</span>
                                <a href="#" class="badge badge-primary text-white" data-toggle="tooltip" data-placement="top" title="Rubriek toevoegen"><i class="fas fa-plus"></i></a>
                                <a href="#" class="badge badge-success text-white" data-toggle="tooltip" data-placement="top" title="Rubriek bewerken"><i class="fas fa-edit"></i></a>
                                <a href="#" class="badge badge-warning text-white" data-toggle="tooltip" data-placement="top" title="Rubriek verwijderen"><i class="fas fa-trash-alt"></i></a>
                                <a href="#" class="badge badge-secondary text-white" data-toggle="tooltip" data-placement="top" title="Rubriek bekijken"><i class="fas fa-search"></i></a>
                            </div>
                        @endif
                        <ul class="category_children">
                            @foreach($parent->children as $child)
                                @if($child->parent == $parent->id)
                                    <li>
                                        <a class="text-dark" href="/rubriek/{{ $child->id }}/{{ str_slug($child->name) }}">{{ $child->name }}</a>
                                        @if ($user = Auth::user())
                                            <div class="category-management">
                                                <span class="badge badge-secondary" data-toggle="tooltip" data-placement="top" title="Volgnummer">{{ $child->order_number }}</span>
                                                <a href="#" class="badge badge-primary text-white" data-toggle="tooltip" data-placement="top" title="Rubriek toevoegen"><i class="fas fa-plus"></i></a>
                                                <a href="#" class="badge badge-success text-white" data-toggle="tooltip" data-placement="top" title="Rubriek bewerken"><i class="fas fa-edit"></i></a>
                                                <a href="#" class="badge badge-warning text-white" data-toggle="tooltip" data-placement="top" title="Rubriek verwijderen"><i class="fas fa-trash-alt"></i></a>
                                                <a href="#" class="badge badge-secondary text-white" data-toggle="tooltip" data-placement="top" title="Rubriek bekijken"><i class="fas fa-search"></i></a>                                            </div>
                                        @endif
                                    </li>
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

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endpush
