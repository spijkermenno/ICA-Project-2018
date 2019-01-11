<a class="dropdown-item bg-dark text-white" href="{{ route('rubrieken') }}">Alle rubrieken</a>
<div class="dropdown-divider"></div>
@foreach($rubrieken as $rubriek)
    @if(is_numeric($rubriek->id))
        <a href="{{ route('rubriek_without_name', ['category_id' => $rubriek->id]) }}"
           class="dropdown-item bg-dark text-white">
            {{$rubriek->name}}
        </a>
    @endif
@endforeach
