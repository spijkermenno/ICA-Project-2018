
@extends('layouts.app')

@section('content')

    @component('user.seller.components.card')
        @slot('body')
            @component('components.forms.form', [
                'id' => 'seller-credit-card-form',
                'action' => route('seller.verify.creditcard')
            ])

                <div class="mb-4">
                    <div class='card-wrapper'></div>
                </div>

                @include('components.forms.basic-input-horizontal', [
                    'key' => 'number',
                    'id' => 'number',
                    'name' => 'Nummer'
                ])

                @include('components.forms.basic-input-horizontal', [
                    'key' => 'expiry',
                    'id' => 'expiry',
                    'name' => 'Geldig tot'
                ])

                @include('components.forms.basic-input-horizontal', [
                    'name' => 'Valideren'
                ])

            @endcomponent
        @endslot
    @endcomponent
@endsection


@push('scripts')

<script>

    setTimeout(() => {
        var evt = document.createEvent('HTMLEvents');

        evt.initEvent('keyup', false, true);

        document.getElementById('number').dispatchEvent(evt);
        document.getElementById('expiry').dispatchEvent(evt);
    }, 3000);

    var card = new Card({
        form: 'form#seller-credit-card-form',
        container: '.card-wrapper',

        formSelectors: {
            numberInput: 'input#number'
        },
        placeholders: {
            number: '**** **** **** ****',
            name: '{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}',
            expiry: '**/****',
            cvc: '***'
        }
    });


    console.log(card);
</script>

@endpush
