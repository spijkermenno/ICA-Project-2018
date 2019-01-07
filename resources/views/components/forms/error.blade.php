@if ($errors->has($key))
    <div class="invalid-feedback">
        <strong>{{ $errors->first($key) }}</strong>
    </div>
@endif
