<fieldset class="form-group">
    <div class="row">
        <legend class="col-form-label col-lg-12 pt-0">
            {{ $name }}
            <span class="text-danger">{{ ($required ?? true) ? '*' : '' }}</span>
        </legend>
        <div class="col-lg-12">
            @foreach($options as $option)
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="{{ $key }}"
                        id="{{ $key }}_{{ str_slug($option) }}"
                        value="{{ str_slug($option) }}"
                        {{ str_slug($option) == old($key, $value ?? null) ? 'checked' : '' }}
                    />
                    <label class="form-check-label" for="{{ $key }}_{{ str_slug($option) }}">
                        {{ $option }}
                    </label>
                </div>
            @endforeach

            @if ($errors->has($key))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first($key) }}</strong>
                </div>
            @endif
        </div>
    </div>
</fieldset>
