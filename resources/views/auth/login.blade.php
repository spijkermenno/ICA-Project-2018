@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        @include('components.forms.basic-input-horizontal', [
                            'key' => 'name',
                            'name' => 'Gebruikersnaam'
                        ])

                        @include('components.forms.basic-input-horizontal', [
                            'key' => 'password',
                            'type' => 'password',
                            'name' => 'Wachtwoord'
                        ])

                        <div class="form-group row">
                            <div class="col-lg-6 offset-lg-4">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="remember" {{ old('remember') ? 'checked' : '' }}> Onthouden
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-8 offset-lg-4">
                                <button type="submit" class="btn btn-primary">
                                    Inloggen
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Wachtwoord vergeten?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
