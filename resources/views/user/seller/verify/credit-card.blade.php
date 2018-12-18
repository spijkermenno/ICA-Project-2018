
@extends('layouts.app')

@section('content')

    @component('user.seller.components.card')
        @slot('body')
            @component('components.forms.form', [
                'action' => route('seller.verify')
            ])

                @include('components.forms.basic-input-horizontal', [
                    'key' => 'creditcard',
                    'name' => 'Creditcard'
                ])

                <div class="form-group row">
                    <div class="col-lg-6 offset-lg-4">
                        <button type="submit" class="btn btn-primary">
                            Valideren
                        </button>
                    </div>
                </div>
            @endcomponent
        @endslot
    @endcomponent
@endsection
