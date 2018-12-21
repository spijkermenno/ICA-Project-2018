<div class="col-12 hidden-sm-down">
    <div class="row p-2">
        @php
            $width = 100 / 7;

            $now = \Illuminate\Support\Carbon::now();
            $start = \Illuminate\Support\Carbon::parse($product->start);
            $end = \Illuminate\Support\Carbon::parse($product->end);

            /*
            Dit is zodat bij de tijdstip 00:00:00 niet die dag wordt laten zien in de kalender.

            Voorbeeld:
            Begin: 19 dec
            Eind: 22 dec 00:00:00 wordt 21 dec 23:59:59
            */
            $end->addSecond(-1);

            $calendar = $start->copy()->startOfWeek();
        @endphp
        @for($i = 0; $i < 14; $i++)
            @php
                $date = str_replace(' ', '<br>', $calendar->format('d M Y'));;
                $classes = [];

                // Dag waarop je kan bieden
                if ($calendar >= $start && $end >= $calendar) {
                    $classes[] = 'bg-primary text-white';
                }
                // Verleden
                if ($calendar < $now && !$calendar->isSameDay($now)) {
                    $classes[] = 'cal-hidden';
                }
                // Huidige dag
                if ($calendar->isSameDay($now)) {
                    $classes[] = 'border-dark text-dark font-weight-bold';
                }
            @endphp

            <div class="border text-center {{ join(' ', $classes) }}" style="width: {{ $width  }}%">
                {!! $date !!}
            </div>

            @php $calendar->addDay(1) @endphp
        @endfor
    </div>
</div>
