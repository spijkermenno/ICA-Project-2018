@extends('layouts.app')

@section('content')

    @component('auth.components.card')
        @slot('page', 'register')

        @slot('body')
            <form role="form" method="POST" action="{{ route('email.verification.send') }}">
                {!! csrf_field() !!}

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
            </form>
        @endslot
    @endcomponent
@endsection
