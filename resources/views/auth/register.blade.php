@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-md-center mt-5 mb-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Register</div>
                <div class="card-body">
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
                                    'name' => 'E-mailadres'
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
                                <button type="submit" class="btn btn-primary btn-block">
                                    Registreer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
