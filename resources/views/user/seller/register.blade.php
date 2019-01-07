
@extends('layouts.app')

@section('content')

    @component('user.seller.components.card')
        @slot('body')

            @component('components.forms.form', [
                'action' => route('seller.register')
            ])

                @include('components.forms.basic-input-horizontal', [
                    'key' => 'bank',
                    'name' => 'Bank'
                ])

                @include('components.forms.basic-input-horizontal', [
                    'key' => 'account_number',
                    'name' => 'Rekeningnummer'
                ])

                @include('components.forms.submit', [
                    'name' => 'Opslaan'
                ])

            @endcomponent

        @endslot
    @endcomponent

@endsection
