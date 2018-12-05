@extends('layouts.app')

@section('content')

    <div class="card m-4" style="width: 18rem;">
        <div class="card-body sidebar">
            <ul class="parents">
                @foreach($sidebar['parents'] as $parent)
                    <li><a href="/rubriek/{{ $parent->id }}">{{ $parent->name }}</a></li>
                @endforeach
            </ul>
            <ul class="current">
                <li>{{ $sidebar['current'] }}</li>
            </ul>
            <ul class="children">
                @foreach($sidebar['children'] as $child)
                    <li><a href="/rubriek/{{ $child->id }}">{{ $child->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>

    <div style="height: 2000px; width: 20px">

    </div>



@endsection
