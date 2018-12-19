
@extends('layouts.app')

@section('content')

    @component('user.seller.components.card')
        @slot('body')

            @component('components.forms.form', [
                'action' => route('email.verify.check')
            ])

                @include('components.forms.basic-input-horizontal', [
                    'key' => 'bank',
                    'name' => 'Bank'
                ])

                @include('components.forms.basic-input-horizontal', [
                    'key' => 'iban',
                    'name' => 'Rekeningnummer'
                ])

                @include('components.forms.basic-input-horizontal', [
                    'name' => 'Opslaan'
                ])

            @endcomponent

        @endslot
    @endcomponent

@endsection
