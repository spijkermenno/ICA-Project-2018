@if (Auth::guest())
    <li class="btn p-1 px-2 m-1 btn-primary"><a href="{{ route('login') }}" class="text-white">Aanmelden</a></li>
@else
    <li class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a href="{{ route('logout') }}" class="dropdown-item"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                  style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    </li>
@endif
