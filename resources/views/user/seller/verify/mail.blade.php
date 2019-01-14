
@extends('layouts.app')

@section('content')

    @component('user.seller.components.card')

        @slot('method', 'mail')

        @slot('body')
            @component('components.forms.form', [
                'action' => route('seller.verify.mail')
            ])

                <div class="alert alert-info" role="alert">
                    Uw brief is op {{ Carbon\Carbon::parse($validation->created_at)->format('j F, Y') }} verstuurd.
                </div>

                @include('components.forms.basic-input-horizontal', [
                    'key' => 'token',
                    'id' => 'token',
                    'name' => 'Code'
                ])

                @include('components.forms.submit', [
                    'name' => 'Valideren'
                ])

            @endcomponent
        @endslot
    @endcomponent
@endsection
