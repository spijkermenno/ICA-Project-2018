<div class="form-group row">
    <label class="col-lg-4 col-form-label text-lg-right">{{ $name }}</label>

    <div class="col-lg-6">
        <input
            type="{{ $type ?? 'text' }}"
            class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}"
            name="{{ $key }}"
            value="{{ old($key) }}"
            required
        />

        @if ($errors->has($key))
            <div class="invalid-feedback">
                <strong>{{ $errors->first($key) }}</strong>
            </div>
        @endif
    </div>
</div>
