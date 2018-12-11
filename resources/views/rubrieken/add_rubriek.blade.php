@extends('layouts.app')

@section('content')
    <div class="row justify-content-md-center mt-5 mb-5">
        <div class="card col-md-8">
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

                    <a href="javascript:history.back()" class="btn btn-warning text-white m-3">
                        Annuleren
                    </a>

                @endcomponent
            </div>
        </div>
    </div>
@endsection
