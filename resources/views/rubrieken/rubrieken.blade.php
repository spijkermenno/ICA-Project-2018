@extends('layouts.app')

@section('content')
    <div class="rubrieken_pagina">
        @if(session()->has('success'))
            <div class="alert alert-primary">
                {{ session()->get('success') }}
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-warning">
                {{ session()->get('error') }}
            </div>
        @endif
        @component('components.title-banner')
        <h1 class="text-white">
            @if(optional(auth()->user())->admin == 1)
                @if(isset($self))
                    {{ $self[0]->name }}
                    @include('rubrieken.components.admin_options', [
                        'order_number' => [
                            'value' => $self[0]->order_number,
                            'active' => true
                        ],
                        'id' => $self[0]->id,
                        'add' => true,
                        'edit' => true,
                        'disable' => true,
                        'view' => false
                    ])
                @else
                    Rubrieken
                    @include('rubrieken.components.admin_options', [
                        'order_number' => [
                            'active'=> false
                        ],
                        'id' => -1,
                        'add' => true,
                        'edit' => false,
                        'disable' => false,
                        'view' => false
                    ])
                @endif
            @else
                Rubrieken
            @endif
        </h1>
            @endcomponent
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
                @if (optional(auth()->user())->admin == 1)
                    @foreach($parents as $parent)
                        <div class="parent-category-management">
                            @include('rubrieken.components.admin_options', [
                                'order_number' => [
                                    'value' => $parent->order_number,
                                    'active' => true
                                ],
                                'id' => $parent->id,
                                'add' => true,
                                'edit' => true,
                                'disable' => true,
                                'view' => true
                            ])
                        </div>
                        <li class="parent" id="{{ $parent->name[0] }}"><a class="text-dark" href="/rubriek/{{ $parent->id }}/{{ str_slug($parent->name) }}">{{ $parent->name }}</a>
                            <ul class="category_children">
                                @foreach($parent->children as $child)
                                    @if($child->parent == $parent->id)
                                        <li>
                                            <a class="text-dark" href="/rubriek/{{ $child->id }}/{{ str_slug($child->name) }}">{{ $child->name }}</a>
                                            <div class="category-management">
                                                @include('rubrieken.components.admin_options', [
                                                    'order_number' => [
                                                        'value' => $child->order_number,
                                                        'active' => true
                                                    ],
                                                    'id' => $child->id,
                                                    'add' => true,
                                                    'edit' => true,
                                                    'disable' => true,
                                                    'view' => true
                                                ])
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                @else
                    @foreach($parents as $parent)
                        <li class="parent" id="{{ $parent->name[0] }}"><a class="text-dark" href="/rubriek/{{ $parent->id }}/{{ str_slug($parent->name) }}">{{ $parent->name }}</a>
                            <ul class="category_children">
                                @foreach($parent->children as $child)
                                    @if($child->parent == $parent->id)
                                        <li>
                                            <a class="text-dark" href="/rubriek/{{ $child->id }}/{{ str_slug($child->name) }}">{{ $child->name }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                @endif
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
                scrollTop: $(hash).offset().top-$('.alphabet').height()-20
            },500);
        });
    </script>
@endpush
