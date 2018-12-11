@extends('layouts.app')

@section('content')
    <div class="card rubriek-card">
        <div class="card-body">
            <h5 class="card-title">Bewerk rubriek {{ $name }}</h5>

            @component('components.forms.form', [
                        'action' => route('update_rubriek', ['id' => $id]),
                        'class' => 'form-horizontal'
                    ])

                @include('components.forms.basic-input', [
                    'name' => 'Naam',
                    'key' => 'name',
                    'value' => $name,
                    'required' => true
                ])

                @include('components.forms.basic-input', [
                    'type' => 'number',
                    'name' => 'Volgnummer',
                    'key' => 'order_number',
                    'value' => $order_number,
                    'required' => true
                ])

                <div class="rubriek-info">Wanneer het ingevoerde volgnummer bezet is zal de rubriek met het op dit moment ingevoerde volgnummer het oude volgnummer van deze rubriek krijgen.</div>

                <button type="submit" class="btn btn-primary text-white">
                    Opslaan
                </button>

                <a href="javascript:history.back()" class="btn btn-warning text-white">
                    Annuleren
                </a>

            @endcomponent
        </div>
    </div>
@endsection
