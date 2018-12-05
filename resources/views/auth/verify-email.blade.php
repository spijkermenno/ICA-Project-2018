@extends('layouts.app')

@section('content')

    @component('auth.components.card')
        @slot('page', 'login')

        @slot('body')
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session("status") }}
                </div>
            @endif

            <form
                role="form"
                method="POST"
                action="{{ route('email.verify.check') }}"
            >
                {!! csrf_field() !!}
                @include('components.forms.basic-input-horizontal', [
                'key' => 'email', 'name' => 'E-mailadres', 'value' =>
                session('email'), 'readonly' => session('email') ? true
                : false ])
                @include('components.forms.basic-input-horizontal', [
                'key' => 'token', 'name' => 'Code', 'value' => $token ??
                null, 'readonly' => isset($token) ])

                <div class="form-group row">
                    <div class="col-lg-6 offset-lg-4">
                        <button type="submit" class="btn btn-primary">
                            Verifieer
                        </button>
                    </div>
                </div>
            </form>
        @endslot
    @endcomponent
@endsection
