<form class="form-inline px-md-3 mx-1 m-xs-1 px-lg-3 d-sm-block p-sm-1" action="{{ route('search') }}" method="get" id="searchForm">
    <div class="input-group">
        @if(isset($searchQuery))
        <input type="text" class="form-control bg-secondary border-secondary text-light" placeholder="Product" name="query" value="{{$searchQuery}}">
        @else
        <input type="text" class="form-control bg-secondary border-secondary text-light" placeholder="Product" name="query">
        @endif
        <span class="input-group-append rounded-right">
            <button class="btn btn-outline-primary"><i class="fa fa-search mr-2"></i> Zoeken</button>
        </span>
    </div>
</form>
