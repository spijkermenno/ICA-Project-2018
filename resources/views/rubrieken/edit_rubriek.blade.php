@extends('layouts.app')

@section('content')
    <h1>Bewerk rubriek {{ $name }}</h1>
    @component('components.forms.form', [
                'action' => route('update_rubriek', ['id' => $id]),
                'class' => 'form-horizontal'
            ])

        @include('components.forms.basic-input', [
            'name' => 'Naam',
            'key' => 'name',
            'value' => $name,
            'required' => true
        ])

        @include('components.forms.basic-input', [
            'type' => 'number',
            'name' => 'Volgnummer',
            'key' => 'order_number',
            'value' => $order_number,
            'required' => true
        ])

        <button type="submit" class="btn btn-primary text-white">
            Opslaan
        </button>

    @endcomponent
@endsection
