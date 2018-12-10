<form
    role="{{ $role ?? 'form' }}"
    method="{{ $method ?? 'POST' }}"
    action="{{ $action }}"
    class="{{ $class ?? '' }}"
>
    {{ csrf_field() }}

    {{ $slot }}
</form>
