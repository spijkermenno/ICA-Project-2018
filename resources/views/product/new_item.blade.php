@extends('layouts.app')

@section('content')
    @component('components.title-banner')
        Nieuwe veiling maken
    @endcomponent

    <form class="w-100 bg-dark px-2 py-5 mb-5 mt-0 mx-auto auction-form-wrapper">
        <div class="w-75 mx-auto">
            <div class="row">
                <div class="form-group col-7">
                    <label for="title">Vul een titel in</label>
                    <input type="text" class="form-control" id="title" placeholder="">
                </div>

                <div class="form-group col-5">
                    <label for="title">Kies een afbeelding</label>
                    <input type="file" class=" p-1 rounded bg-white form-control-file" id="file" multiple accept="image/*" />
                </div>
            </div>

            <div class="row">
                <div class="form-group col-12">
                    <label for="description">Vul een beschrijving in</label>
                    <textarea class="form-control" id="description" rows="3"></textarea>
                </div>
            </div>

            @include('components.forms.rubrieken_select')
            <div class="row">
                <div class="form-group col-lg-4">
                    <label for="description">Vul een start prijs in</label>
                    <input type="number" class="form-control" id="price" placeholder="">
                </div>

                <div class="form-group col-lg-4">
                    <label for="description">Vul de verzendkosten in</label>
                    <input type="number" class="form-control" id="price" placeholder="">
                </div>

                <div class="form-group col-lg-4">
                    <label for="description">kies een betaal methode</label>
                    <select class="form-control">
                        @foreach($payment_methods as $method)
                            <option value="{{$method->name}}">{{$method->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-12">
                    <label for="title">Vul in wanneer de betaling moet worden gedaan</label>
                    <input type="text" class="form-control" id="paymentInstruction" placeholder="">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-6">
                    <label for="description">Vul de veiling looptijd in</label>
                    <select class="form-control" id="duration">
                        @foreach($auctionDurations as $duration)
                            <option
                                value="{{$duration['value']}}" {{$duration['default']}}>{{$duration['text']}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-lg-6">
                    <label for="description">Deze veiling eindigd op</label>
                    <input type="datetime-local" disabled class="form-control" id="endDate">
                </div>
            </div>

        </div>
    </form>
@endsection
