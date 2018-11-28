@extends('layouts.app')

@section('content')
    <div class="container">
        <ul>
            @foreach($parents as $parent)
                <li>{{ $parent->name }}</li>
                <ul>
                    @foreach($children as $child)
                        @if($child->parent == $parent->id)
                            <li>{{ $child->name }}</li>
                        @endif
                    @endforeach
                </ul>
            @endforeach
        </ul>
    </div>
@endsection
