@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Rubrieken</h1>
        <div class="alphabet">
            <ul>
                @foreach($alphabet as $item)
                    <li>
                        @if($item['active'] == true)
                            <a class="text-dark" href="#{{ $item['letter'] }}">{{ $item['letter'] }}</a>
                        @else
                            {{ $item['letter'] }}
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="categories">
            <ul class="category_parents">
                @foreach($parents as $parent)
                    <li class="parent" id="{{ $parent->name[0] }}"><a class="text-dark" href="/rubrieken/{{ $parent->id }}">{{ $parent->name }}</a>
                        <ul class="category_children">
                            @foreach($children as $child)
                                @if($child->parent == $parent->id)
                                    <li><a class="text-dark" href="/rubrieken/{{ $child->id }}">{{ $child->name }}</a></li>
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
                scrollTop: $(hash).offset().top-70
            },500);
        });

        $(document).ready(function() {
            var s = $(".alphabet");
            var pos = s.position();
            $(window).scroll(function() {
                var windowpos = $(window).scrollTop();
                if (windowpos >= pos.top) {
                    s.addClass("stick");
                } else {
                    s.removeClass("stick");
                }
            });
        });
    </script>
@endpush
