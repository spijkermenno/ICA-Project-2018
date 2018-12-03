@foreach($rubrieken as $rubriek)
    <a href="/rubrieken/{{ $rubriek->id }}" class="dropdown-item bg-dark text-white">
        {{$rubriek->name}}
    </a>
@endforeach
<div class="dropdown-divider"></div>
<a class="dropdown-item bg-dark text-white" href="/rubrieken/">Alle rubrieken</a>
