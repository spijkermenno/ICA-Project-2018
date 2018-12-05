@extends('layouts.app')

@section('content')

    @component('auth.components.card')
        @slot('page', 'register')

        @slot('body')
            <form role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-6">
                        @include('components.forms.basic-input', [
                            'key' => 'name',
                            'name' => 'Gebruikersnaam'
                        ])

                        @include('components.forms.basic-input', [
                            'key' => 'email',
                            'type' => 'email',
                            'name' => 'E-mailadres',
                            'value' => session('email.verification.email'),
                            'readonly' => true
                        ])

                        @include('components.forms.basic-input', [
                            'key' => 'password',
                            'type' => 'password',
                            'name' => 'Wachtwoord'
                        ])

                        @include('components.forms.basic-input', [
                            'key' => 'password_confirmation',
                            'type' => 'password',
                            'name' => 'Herhaal wachtwoord'
                        ])
                    </div>

                    <div class="col-md-6">
                        @include('components.forms.basic-input', [
                            'key' => 'firstname',
                            'name' => 'Voornaam'
                        ])

                        @include('components.forms.basic-input', [
                            'key' => 'lastname',
                            'name' => 'Achternaam'
                        ])

                        @include('components.forms.datepicker', [
                            'key' => 'birthday',
                            'name' => 'Geboortedatum',
                            'notAfter' => today()->addDay()->toDateString()
                        ])

                        @include('components.forms.select', [
                            'key' => 'secret_question_id',
                            'name' => 'Herstel vraag',
                            'options' => $questions ?? [],
                            'name_key' => 'question'
                        ])

                        @include('components.forms.basic-input', [
                            'key' => 'secret_question_answer',
                            'name' => 'Herstel antwoord'
                        ])

                    </div>
                </div>

                <hr>

                <div class="row">

                    <div class="col-md-6">
                        @include('components.forms.basic-input', [
                            'key' => 'adress_line_1',
                            'name' => 'Adresregel 1'
                        ])
                    </div>

                    <div class="col-md-6">
                        <!-- Filler -->
                    </div>

                    <div class="col-md-6">
                        @include('components.forms.basic-input', [
                            'key' => 'adress_line_2',
                            'name' => 'Adresregel 2',
                            'required' => false
                        ])

                        @include('components.forms.basic-input', [
                            'key' => 'postalcode',
                            'name' => 'Postcode'
                        ])
                    </div>

                    <div class="col-md-6">
                        @include('components.forms.basic-input', [
                            'key' => 'city',
                            'name' => 'Plaatsnaam'
                        ])

                        @include('components.forms.basic-input', [
                            'key' => 'country',
                            'name' => 'Land'
                        ])
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary btn-block text-white">
                            Registreer
                        </button>
                    </div>
                </div>
            </form>
        @endslot
    @endcomponent
@endsection
