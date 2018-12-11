@extends('layouts.app')

@section('content')
    <div class="card rubriek-card">
        <div class="card-body">
            <h5 class="card-title">Uitfaseren rubriek {{ $name }}</h5>
            <p class="card-text">Weet u zeker dat u deze rubriek en alle ondergelegen rubrieken wilt uitfaseren?</p>
            @component('components.forms.form', [
                        'action' => route('disable_rubriek', ['id' => $id]),
                        'class' => 'form-horizontal'
                    ])

                <button type="submit" class="btn btn-primary text-white">
                    Bevestig
                </button>

                <a href="javascript:history.back()" class="btn btn-warning text-white">
                    Annuleren
                </a>

            @endcomponent
        </div>
    </div>
@endsection
