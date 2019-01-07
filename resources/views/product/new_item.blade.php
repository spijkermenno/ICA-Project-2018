@extends('layouts.app')

@section('content')
    @component('components.title-banner')
        Nieuwe veiling maken
    @endcomponent

    <form class="w-100 bg-dark px-2 py-5 mb-5 mt-0 mx-auto auction-form-wrapper rounded-bottom" method="post" action="/product/toevoegen/checken/" enctype="multipart/form-data">
        <div class="w-75 mx-auto">
            @include('components.forms.rubrieken_select')
            <div class="row">
                <div class="form-group col-lg-7">
                    <label for="title">Vul een titel in</label>
                    <input type="text" class="form-control {{ $errors->has("title") ? " is-invalid" : "" }}" id="title" name="title" placeholder="">
                    @include('components.forms.error', ['key' => 'title'])
                </div>

                <div class="form-group col-lg-5">
                    <label for="title">Kies een afbeelding</label>
                    <input type="file" name="files[]" class=" p-1 rounded bg-white form-control-file {{ $errors->has("files") ? " is-invalid" : "" }}" id="file" multiple accept="image/*" max="5" />
                    @include('components.forms.error', ['key' => 'files'])
                </div>
            </div>

            <div class="row">
                <div class="form-group col-12">
                    <label for="description">Vul een beschrijving in</label>
                    <textarea class="form-control {{ $errors->has("description") ? " is-invalid" : "" }}" name="description" id="description" rows="3"></textarea>
                    @include('components.forms.error', ['key' => 'description'])
                </div>

            </div>

            <div class="row">
                <div class="form-group col-lg-4">
                    <label for="description">Vul een start prijs in</label>
                    <input type="number" min="0" step="0.01" class="form-control {{ $errors->has("start_price") ? " is-invalid" : "" }}" id="price" name="start_price" placeholder="">
                    @include('components.forms.error', ['key' => 'start_price'])
                </div>

                <div class="form-group col-lg-4">
                    <label for="description">Vul de verzendkosten in</label>
                    <input type="number" min="0" step="0.01" class="form-control {{ $errors->has("shipping_cost") ? " is-invalid" : "" }}" id="price" name="shipping_cost" placeholder="">
                    @include('components.forms.error', ['key' => 'shipping_cost'])
                </div>

                <div class="form-group col-lg-4">
                    <label for="payment_method">kies een betaal methode</label>
                    <select class="form-control {{ $errors->has("payment_method") ? " is-invalid" : "" }}" name="payment_method">
                    @foreach($payment_methods as $method)
                            <option value="{{$method->name}}">{{$method->name}}</option>
                        @endforeach
                    </select>
                    @include('components.forms.error', ['key' => 'payment_method'])
                </div>
            </div>

            <div class="row">
                <div class="form-group col-12">
                    <label for="title">Vul in wanneer de betaling moet worden gedaan</label>
                    <input type="text" class="form-control {{ $errors->has("payment_instruction") ? " is-invalid" : "" }}" name="payment_instruction" id="paymentInstruction" placeholder="">
                    @include('components.forms.error', ['key' => 'payment_instruction'])
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-6">
                    <label for="description">Vul de veiling looptijd in</label>
                    <select class="form-control {{ $errors->has("duration") ? " is-invalid" : "" }}" name="duration" id="duration">
                        @foreach($auctionDurations as $duration)
                            <option
                                value="{{$duration['value']}}" {{$duration['default']}}>{{$duration['text']}}</option>
                        @endforeach
                    </select>
                    @include('components.forms.error', ['key' => 'duration'])
                </div>

                <div class="form-group col-lg-6">
                    <label>Deze veiling eindigd op</label>
                    <input type="datetime-local" disabled class="form-control" id="endDate">
                </div>
            </div>
            <div class="row mt-3">
                <div class="form-group col-12">
                    <input type="submit" class="form-control btn btn-primary" id="" placeholder="" value="Plaats veiling" />
                </div>
            </div>
            {{ csrf_field() }}
        </div>
    </form>
@endsection
