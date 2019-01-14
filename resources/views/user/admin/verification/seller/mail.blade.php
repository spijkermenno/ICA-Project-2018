
@extends('layouts.app')

@section('content')
    @if($pagination->count() > 0)
        <nav class="mt-5 mb-5 no-print">
            <!-- <div class="btn-group" role="group" aria-label="Basic example"> -->
                <button type="button" class="btn btn-secondary" onclick="window.print();return false;">Printen</button>
                <a
                    class="btn btn-primary {{ $verification->sent ? 'disabled' : '' }}"
                    onclick="event.preventDefault();document.getElementById('seller-letter-form').submit();"
                >
                    Markeer als verzonden
                </a>

                <form id="seller-letter-form" action="{{ route('admin.verifications.seller.letter.sent') }}" method="POST"
                    style="display: none;">
                    <input type="hidden" name="user_name" value="{{ $user->name }}">
                    {{ csrf_field() }}
                </form>
        </nav>

        @include('user.seller.components.letter')

        <nav class="mt-5">
            {{ $pagination }}
        </nav>
    @else
        <h5 class="mt-5">Er zijn geen actieve verificaties</h5>
    @endif
@endsection
