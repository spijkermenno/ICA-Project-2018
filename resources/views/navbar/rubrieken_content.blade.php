@foreach($rubrieken as $rubriek)
    <a href="" class="dropdown-item bg-dark text-white">
        {{$rubriek->name}}
    </a>
@endforeach
