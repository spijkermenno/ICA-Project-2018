@extends('layouts.app')

@section('content')

    @component('user.seller.components.card')
        @slot('body')
            @component('components.forms.form', [
                'action' => route('seller.verify')
            ])

                <div class="alert alert-primary" role="alert">
                    Om verkoper te worden moeten we uw gegevens valideren. <br/>
                    Dit kan doormiddel van een brief die u via de post toegestuurd
                    krijgt of door uw creditcard nummer in te vullen.
                </div>

                <hr>

                @include('user.components.profile', [
                    'user' => auth()->user()
                ])

                <hr>

                @include('components.forms.radios', [
                    'key' => 'verification_method',
                    'name' => 'Methode',
                    'options' => $verification_methods
                ])

                @include('components.forms.submit', [
                    'name' => 'Versturen'
                ])

            @endcomponent
        @endslot
    @endcomponent
@endsection
