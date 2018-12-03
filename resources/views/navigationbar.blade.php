<nav class="navbar navbar-expand-lg navbar-dark bg-dark text-white">
    <div class="container">
        <a class="navbar-brand text-white" href="{{ url('/') }}">
            {{ config('app.name', 'EenmaalAndermaal') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                @include('navbar.content')
               @include('navbar.search_field')
            </ul>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav">
                @include('navbar.auth')
            </ul>
        </div>

    </div>
</nav>
