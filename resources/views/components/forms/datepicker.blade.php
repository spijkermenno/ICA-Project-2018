<div class="form-group row">
    <label class="col-lg-12 col-form-label text-lg-left">
        {{ $name }}
        <span class="text-danger">{{ ($required ?? true) ? '*' : '' }}</span>
    </label>

    <div class="col-lg-12">
        <date-picker
            name="{{ $key }}"
            input-class="form-control"
            format="dd-MM-yyyy"
            value="{{ old($key) }}"
            :language="lang.nl"
            :disabled-dates="{
                @if(isset($notAfter))
                    from: new Date('{{ $notAfter }}')
                @endif
            }"
        ></date-picker>

        @if ($errors->has($key))
            <div class="text-danger mt-2">
                <strong>{{ $errors->first($key) }}</strong>
            </div>
        @endif
    </div>
</div>
