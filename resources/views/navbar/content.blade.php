<li class="nav-item dropdown">
    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" style="line-height: 28px">
        Rubrieken
    </a>
    <div class="dropdown-menu dropdown-menu-center bg-dark border-0" aria-labelledby="navbarDropdownMenuLink">
        <a href="" class="dropdown-item bg-dark">
            @if(isset($rubrieken))
                @include('navbar.rubrieken_content')
            @endif
        </a>
    </div>
</li>
