<div class="container">
    <div class="row justify-content-md-center mt-5 mb-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0 pt-2">
                    <ul class="nav nav-tabs border-0">
                        <li class="nav-item">
                            <a class="nav-link {{ !isset($method) && !($registration ?? false) ? 'active' : (($registration ?? false) ? 'disabled' : '') }}" href="{{ route('seller.verify') }}">Methode</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ isset($method) ? 'active' : 'disabled' }}" href="{{ isset($method) ? route('seller.verify.' . $method) : '' }}">Activatie</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($registration ?? false) ? 'active' : (session('seller.verification.verified') ? '' : 'disabled') }}" href="{{ ($registration ?? false) || session('seller.verification.verified') ? route('seller.register') : '' }}">Registratie</a>
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
