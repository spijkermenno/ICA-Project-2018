@extends('layouts.app')

@section('content')

    @component('user.seller.components.card')
        @slot('body')
            @component('components.forms.form', [
                'action' => route('email.verify.check')
            ])

                <div class="row">
                    <div class="col-md-6">

                        @include('components.forms.basic-input', [
                            'key' => 'bank',
                            'name' => 'Bank'
                        ])

                    </div>
                </div>

                @include('components.forms.basic-input', [
                    'key' => 'iban',
                    'name' => 'IBAN'
                ])

                @include('components.forms.radios', [
                    'key' => 'verification_method',
                    'name' => 'Methode',
                    'options' => $verification_methods
                ])


1	Lid ingelogd
2	Systeem toont inschrijfgegevens
3	Selecteer identificatiemethode
4	Selecteer methode van betaling
5	Vastleggen gegevens

3	Indien identificatiemethode is post: stuur brief met bevestigingscode
6	Lid start login
7	Lid kiest voor verkoopaccount activeren
8	Systeem toont invoermogelijkheid voor bevestigingscode
9	Lid voert bevestigingscode in
10	Gegevens worden vastgelegd
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6 offset-lg-4">
                        <button type="submit" class="btn btn-primary">
                            Verifiëren
                        </button>
                    </div>
                </div>
            @endcomponent
        @endslot
    @endcomponent
@endsection
