<div class="col-12 p-2">
    <div class="row">
        @php
            setlocale(LC_TIME, "nl_NL");

            $week = array(
            0 => 'Mon',
            1 => 'Tue',
            2 => 'Wed',
            3 => 'Thu',
            4 => 'Fri',
            5 => 'Sat',
            6 => 'Sun',
            );

            if ($product['auction_length'] > 10){
                $end_day = 21;
                $calender = [0 => null, 1 => null,2 => null,3 => null,4 => null,5 => null,6 => null,7 => null,8 => null,9 => null,10 => null,11 => null,12 => null,13 => null,14 => null,15 => null, 16 => null,17 => null,18 => null,19 => null,20 => null];
            }else{
                $calender = [0 => null, 1 => null,2 => null,3 => null,4 => null,5 => null,6 => null,7 => null,8 => null,9 => null,10 => null,11 => null,12 => null,13 => null];
                $end_day = 14;
            }
            $start_day = 0;
            $days_to_go = 0;
            $start_date = $product['start_date'];
            $end_date = '';
            $date_format = 'd M Y';
            $enddatestring = strtotime($start_date  . '+' . $product['auction_length'] . ' day');
            $startdatestring = strtotime($start_date);
            $end_date = date($date_format, $enddatestring);

            foreach ($week as $key => $value){
                $day = date('D', strtotime($start_date));
                $today = date($date_format, strtotime($start_date));
                if ($value == $day){
                    $start_day = $key;
                    $end_day -= $key;
                    $days_to_go = -$key;
                }
            }

            for ($i = 0; $i < count($calender); $i++){
                if ($calender[$i] == null){
                    $daytimestring = strtotime($start_date  . $days_to_go.' day');
                    $calender[$i]['date'] = date($date_format, $daytimestring);

                    if ($daytimestring >= $startdatestring && $daytimestring <= $enddatestring){
                        $calender[$i]['style'] = 'bg-gray border';
                    } else {
                        $calender[$i]['style'] = '';
                    }
                    $days_to_go++;
                }
            }

            $width = 100 / 7;
        @endphp
        @foreach($calender as $date)
            <div class="border text-center {{$date['style']}}" style="width: {{$width}}%">{{$date['date']}}</div>
        @endforeach
    </div>
</div>
