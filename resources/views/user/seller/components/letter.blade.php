@push('styles')
<style>

    @media print {
        pre {
            border: none;
        }
        @page { margin: 0; }
        body {
            margin: 1.6cm;
            visibility:hidden;
        }
        .no-print {
            display:none;
        }
        .print {visibility:visible;}
    }

</style>
@endpush

<pre class="mt-10 print">
Eenmaal andermaal
Droogveld 9
6916 LJ TOLKAMER
www.iproject1.icasites.nl

{{ $user->firstname . ' ' . $user->lastname }}
{{ $user->adress_line_1 }}
@if(!empty($user->adress_line_2))
    {{ $user->adress_line_2 }}
@endif
{{ $user->postalcode }} {{ $user->city }}
{{ $user->country }}

Beste {{ $user->firstname . ' ' . $user->lastname }},

Vul de volgende verificatie code in op in het formulier op de website:

    {{ $verification->token }}

Met vriendelijke groet,

Eenmaal andermaal.
www.iproject1.icasites.nl
</pre>
