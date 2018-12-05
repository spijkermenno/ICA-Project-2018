@extends('layouts.app')

@section('content')
<pre>
    @foreach($children as $child)
    {{var_dump($child)}}
    @endforeach

@endsection
