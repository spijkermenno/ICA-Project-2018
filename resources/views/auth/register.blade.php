@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <form role="form" method="POST" action="{{ url('/register') }}">
                        {!! csrf_field() !!}

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

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6 offset-lg-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
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
