<div class="form-group row">
        <label class="col-lg-12 col-form-label text-lg-left">{{ $name }}</label>

        <div class="col-lg-12">
            <select
                class="form-control {{ $errors->has($key) ? ' is-invalid' : '' }}"
                name="{{ $key }}"
            >
                @foreach($options as $option)
                    <option value="{{ $option->id }}" {{ old($key) == $option->id ? 'required' : '' }}>
                        {{ $option->{$name_key ?? 'name'} }}
                    </option>
                @endforeach
            </select>

            @if ($errors->has($key))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first($key) }}</strong>
                </div>
            @endif
        </div>
    </div>
