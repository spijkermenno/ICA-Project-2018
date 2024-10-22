@if (Auth::guest())
    <li class="nav-item p-2"><a class="nav-link" href="/login/">Inloggen</a></li>
    <li class="btn btn-primary"><a href="/register/" class="nav-link text-white">Registreren</a></li>
@else
    <li class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle pt-3 mx-2" id="navbarDropdownMenuLink" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu dropdown-menu-left bg-dark border-0 p-2" aria-labelledby="navbarDropdownMenuLink">
            @if (!auth()->user()->seller)
                <a href="{{ route('seller.verify') }}" class="dropdown-item bg-dark text-white">
                    Verkoper worden
                </a>
            @endif

            @if (auth()->user()->admin)
                <a href="{{ route('admin.verifications.seller.letter') }}" class="dropdown-item bg-dark text-white">
                    Brieven
                </a>
            @endif

            
            <a href="{{ route('account.my_bids') }}" class="dropdown-item bg-dark text-white">
                Mijn biedingen
            </a>

            @if (auth()->user()->seller)
                <a href="{{ route('account.auctions') }}" class="dropdown-item bg-dark text-white">
                    Mijn veilingen
                </a>
            @endif

            <a href="{{ route('logout') }}" class="dropdown-item bg-dark text-white"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                Uitloggen
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                  style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    </li>
    <li class="nav-item p-2">
        <div class="btn btn-outline-primary d-flex align-content-center align-items-center">
            <a href="{{ route('auction.add') }}" class="d-flex" style="color: inherit; text-decoration: none">
                <i class="mr-2 fas fa-gavel" style="font-size: 1.5rem"></i>
                <p class="m-0">Plaats veiling</p>
            </a>
        </div>
    </li>
@endif
