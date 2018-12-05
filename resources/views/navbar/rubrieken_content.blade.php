@foreach($rubrieken as $rubriek)
    @if(is_numeric($rubriek->id))
        <a href="/rubriek/{{$rubriek->id . '/' . seo_url($rubriek->name)}}"
           class="dropdown-item bg-dark text-white">
            {{$rubriek->name}}
        </a>
    @endif
@endforeach
<div class="dropdown-divider"></div>
<a class="dropdown-item bg-dark text-white" href="/rubrieken/">Alle rubrieken</a>
