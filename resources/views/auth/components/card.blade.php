<div class="container">
    <div class="row justify-content-md-center mt-5 mb-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0 pt-2">

                    <ul class="nav nav-tabs border-0">
                        <li class="nav-item">
                            <a class="nav-link {{ $page == 'login' ? 'active' : '' }}" href="/login/">Inloggen</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $page == 'register' ? 'active' : '' }}" href="/register/">Registreren</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ $body }}
                </div>
            </div>
        </div>
    </div>
</div>
