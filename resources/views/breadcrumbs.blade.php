@if(isset($breadcrumbs))
    <div class="w-100 mb-2 d-none d-sm-block d-md-block d-lg-block d-xl-block m-2">

        <ol class="breadcrumb w-50 p-1 m-0 bg-white ">

            @foreach ($breadcrumbs as $breadcrumb)

                <li class="breadcrumb-item">
                    @if($breadcrumb['link'] != '')
                        <a href="{{ route($breadcrumb['link']) }}">{{$breadcrumb['name']}}</a>
                    @else
                        {{$breadcrumb['name']}}
                    @endif
                </li>

            @endforeach

        </ol>
    </div>
@endif