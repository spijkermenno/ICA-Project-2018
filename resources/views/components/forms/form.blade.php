<form
    role="{{ $role ?? 'form' }}"
    method="{{ $method ?? 'POST' }}"
    action="{{ $action }}"
    {{ ($id ?? null) ? 'id=' . $id : '' }}
    class="{{ $class ?? '' }}"
>
    {{ csrf_field() }}

    {{ $slot }}
</form>
