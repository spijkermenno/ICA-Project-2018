<div class="form-group row">
    <label class="col-lg-12 col-form-label text-lg-left">{{ $name }}</label>

    <div class="col-lg-12">
        <date-picker
            name="date"
            value="{{ old($key) }}"
        ></date-picker>

        @if ($errors->has($key))
            <div class="invalid-feedback">
                <strong>{{ $errors->first($key) }}</strong>
            </div>
        @endif
    </div>
</div>
