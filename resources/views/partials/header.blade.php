<!-- Right links -->
<ul id="navbar-nav" class="navbar-nav ms-auto d-flex flex-row ">
    <li class="nav-item p-2">
        <a class="nav-link me-3 me-lg-0" href="#">
            <i class="fas fa-bell"></i>
            <span class="badge rounded-pill badge-notification bg-danger">1</span>
        </a>
    </li>

    <!-- Icon -->
    <li class="nav-item me-3 me-lg-0 p-2">
        <a class="nav-link" href="https://github.com/MatteoRuffa/laravel-auth">
            <i class="fab fa-github"></i>
        </a>
    </li>
    <li class="nav-item p-2">
        <a class="nav-link me-3 me-lg-0" href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" title="Logout">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>
    <li class="nav-item p-2">
        <a class="nav-link" href="#" id="userProfile" role="button">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::user()->name}}</span>
            <img class="img-profile rounded-circle" src="/images/user.webp">
        </a>
    </li>
</ul>