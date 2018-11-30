@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Rubrieken</h1>
        <div class="alphabet">
            <ul>
                @foreach($alphabet as $item)
                    <li>
                        @if($item['active'] == true)
                            <a href="#{{ $item['letter'] }}">{{ $item['letter'] }}</a>
                        @else
                            {{ $item['letter'] }}
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        <ul>
            @foreach($parents as $parent)
                <li id="{{ $parent->name[0] }}"><a href="/rubrieken/{{ $parent->id }}">{{ $parent->name }}</a></li>
                <ul>
                    @foreach($children as $child)
                        @if($child->parent == $parent->id)
                            <li><a href="/rubrieken/{{ $child->id }}">{{ $child->name }}</a></li>
                        @endif
                    @endforeach
                </ul>
            @endforeach
        </ul>
    </div>
@endsection
