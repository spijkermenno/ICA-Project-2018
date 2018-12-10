@extends('layouts.app')

@section('content')

    @component('auth.components.card')
        @slot('page', 'register')

        @slot('body')
            @component('components.forms.form', [
                'action' => route('email.verify.check')
            ])
                @include('components.forms.basic-input-horizontal', [
                    'key' => 'email',
                    'name' => 'E-mailadres',
                    'value' => session('email'),
                    'readonly' => session('email') ? true : false
                ])

                @include('components.forms.basic-input-horizontal', [
                    'key' => 'token',
                    'name' => 'Code',
                    'value' => $token ?? null,
                    'readonly' => isset($token)
                ])

                <div class="form-group row">
                    <div class="col-lg-6 offset-lg-4">
                        <button type="submit" class="btn btn-primary">
                            Verifieer
                        </button>
                    </div>
                </div>
            @endcomponent
        @endslot
    @endcomponent
@endsection
