
<div class="form-group row">
    <label class="col-lg-12 col-form-label text-lg-left">{{ $name }}</label>

    <div class="col-lg-12">
        <input
            type="{{ $type ?? 'text' }}"
            class="form-control {{ $errors->has($key) ? ' is-invalid' : '' }}"
            name="{{ $key }}"
            value="{{ old($key) }}"
            required
        >

        @if ($errors->has($key))
            <div class="invalid-feedback">
                <strong>{{ $errors->first($key) }}</strong>
            </div>
        @endif
    </div>
</div>
