@extends('layouts.app')

@section('content')
    <div class="card rubriek-card">
        <div class="card-body">
            <h5 class="card-title">Subrubriek toevoegen aan {{ $parent_name }}</h5>

            @component('components.forms.form', [
                        'action' => route('add_rubriek', ['parent_id' => $parent_id]),
                        'class' => 'form-horizontal'
                    ])

                @include('components.forms.basic-input', [
                    'key' => 'name',
                    'name' => 'Naam'
                ])

                <button type="submit" class="btn btn-primary text-white">
                    Toevoegen
                </button>

                <a href="javascript:history.back()" class="btn btn-warning text-white">
                    Annuleren
                </a>

            @endcomponent
        </div>
    </div>
@endsection
