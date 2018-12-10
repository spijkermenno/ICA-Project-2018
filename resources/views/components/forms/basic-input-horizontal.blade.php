<div class="form-group row">
    <label class="col-lg-4 col-form-label text-lg-right">
        {{ $name }}
        <span class="text-danger">{{ ($required ?? true) ? '*' : '' }}</span>
    </label>

    <div class="col-lg-6">
        <input
            type="{{ $type ?? 'text' }}"
            class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}"
            name="{{ $key }}"
            value="{{ $value ?? old($key) }}"
            {{ ($readonly ?? false) ? 'readonly="readonly"' : '' }}
            required
        />

        @if ($errors->has($key))
            <div class="invalid-feedback">
                <strong>{{ $errors->first($key) }}</strong>
            </div>
        @endif
    </div>
</div>
