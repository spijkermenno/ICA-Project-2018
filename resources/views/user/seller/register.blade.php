
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

            @endcomponent

        @endslot
    @endcomponent

@endsection
