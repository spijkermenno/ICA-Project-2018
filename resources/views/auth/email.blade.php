@extends('layouts.app')

@section('content')

    @component('auth.components.card')
        @slot('page', 'register')

        @slot('body')
            @component('components.forms.form', [
                'action' => route('email.verification.send')
            ])
                @include('components.forms.basic-input-horizontal', [
                    'key' => 'email',
                    'name' => 'E-mailadres'
                ])

                <div class="form-group row">
                    <div class="col-lg-6 offset-lg-4">
                        <button type="submit" class="btn btn-primary">
                            Registreren
                        </button>
                    </div>
                </div>
            @endcomponent
        @endslot
    @endcomponent
@endsection
