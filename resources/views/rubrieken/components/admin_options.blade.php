@if($order_number['active'])
    <span class="badge badge-secondary" data-toggle="tooltip" data-placement="top" title="Volgnummer">{{ $order_number['value'] }}</span>
@endif
@if($add)
    <a href="/rubrieken/toevoegen/{{ $id }}/" class="badge badge-primary text-white" data-toggle="tooltip" data-placement="top" title="Rubriek toevoegen"><i class="fas fa-plus"></i></a>
@endif
@if($edit)
    <a href="/rubrieken/bewerken/{{ $id }}/" class="badge badge-success text-white" data-toggle="tooltip" data-placement="top" title="Rubriek bewerken"><i class="fas fa-edit"></i></a>
@endif
@if($disable)
    <a href="/rubrieken/uitfaseren/{{ $id }}/" class="badge badge-warning text-white" data-toggle="tooltip" data-placement="top" title="Rubriek uitfaseren"><i class="fas fa-trash-alt"></i></a>
@endif
@if($view)
    <a href="/rubrieken/bekijken/{{ $id }}/" class="badge badge-secondary text-white" data-toggle="tooltip" data-placement="top" title="Rubriek bekijken"><i class="fas fa-search"></i></a>
@endif

