<div class="form-group row">
    <label class="col-lg-12 col-form-label text-lg-left">
        {{ $name }}
        <span class="text-danger">{{ ($required ?? true) ? '*' : '' }}</span>
    </label>

    <div class="col-lg-12">
        <input
            type="{{ $type ?? 'text' }}"
            class="form-control {{ $errors->has($key) ? ' is-invalid' : '' }}"
            name="{{ $key }}"
            value="{{ ($value ?? old($key)) ?? ($default ?? '') }}"
            {{ ($id ?? null) ? 'id=' . $id : '' }}
            {{ ($required ?? true) ? 'required' : '' }}
            {{ ($readonly ?? null) ? 'readonly="readonly"' : '' }}
            {{ ($disabled ?? null) ? 'disabled="disabled"' : '' }}
        >

        @if ($errors->has($key))
            <div class="invalid-feedback">
                <strong>{{ $errors->first($key) }}</strong>
            </div>
        @endif
    </div>
</div>
