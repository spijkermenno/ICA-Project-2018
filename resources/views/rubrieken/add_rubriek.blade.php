@extends('layouts.app')

@section('content')
    <h1>Rubriek toevoegen onder {{ $parent_name }}</h1>
    @component('components.forms.form', [
                'action' => route('add_rubriek', ['parent_id' => $parent_id]),
                'class' => 'form-horizontal'
            ])

        @include('components.forms.basic-input', [
            'key' => 'name',
            'name' => 'Naam'
        ])

        <button type="submit" class="btn btn-primary text-white">
            Inloggen
        </button>

    @endcomponent
@endsection
