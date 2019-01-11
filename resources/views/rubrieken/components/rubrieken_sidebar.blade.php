<div class="sidebar card">
    <div class="card-body">
        <h3>Rubrieken</h3>
        <div class="sidebar-menu">
            <a href="{{ route('rubrieken') }}"><strong>Alle</strong></a>
            @foreach($sidebar['parents'] as $parent)
                <ul>
                    <li><a href="{{ route('rubriek_without_name', ['category_id' => $parent->id]) }}">{{ $parent->name }}</a></li>
                    @endforeach
                    <ul>
                        <li><strong>{{ $sidebar['current'][0]->name }}</strong></li>
                        <ul>
                            @foreach($sidebar['children'] as $child)
                                <li><a href="{{ route('rubriek_without_name', ['category_id' => $child->id]) }}">{{ $child->name }}</a></li>
                            @endforeach
                        </ul>
                    </ul>
                </ul>
        </div>
    </div>
</div>
