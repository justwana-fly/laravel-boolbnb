<nav id="nav-side" class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">

  <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar"
    aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    <a class="navbar-brand" href="#">Menu</a>
  </button>
  <!-- <div  class="p-3 ms-4 my-1 position-relative">
    <div class="logo-container"> -->
      <div class="d-flex ">
        <div class="logo-container align-items-center">
             <img class="logo-large logo-filter" src="{{ asset('image/logo-6.png') }}" alt="Logo grande">
             <img class="logo-small logo-filter" src="{{ asset('image/logo-only-B.png') }}" alt="Logo piccolo">
        </div>
      </div>

          <!-- <a href="http://localhost:5174" class="text-decoration-none text-white">
            <p>
              <i class="fs-4 fa-solid fa-house-flood-water"></i>
            </p>
          </a> -->
        <!-- </div> -->
    <!-- <div class="bubbles">
      <div></div>
    </div> -->
  <!-- </div> -->
  @include('partials.header')



    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
      aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
          
          <li class="nav-item">
            <a class="nav-link {Route::currentRouteName() == 'admin.apartments.index' ? 'active' : ''}}"
              href="{{route('admin.apartments.index')}}">Apartments</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {Route::currentRouteName() == 'admin.services.index' ? 'active' : ''}}"
              href="{{route('admin.services.index')}}">Services</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link {Route::currentRouteName() == 'admin.promotions.index' ? 'active' : ''}}"
              href="{{route('admin.promotions.index')}}">Promotions</a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link {Route::currentRouteName() == 'admin.lead.index' ? 'active' : ''}}"
              href="{{route('admin.leads.index')}}">Messages</a>
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link {Route::currentRouteName() == 'admin.services.index' ? 'active' : ''}}"
              href="{{route('admin.messages.index')}}">Messages</a>
          </li> --}}
          <li class="nav-item">
            <a class="nav-link" href="http://localhost:5174">
              Switch to Client Side
            </a>
          </li>

        </ul>
        <!-- <form class="d-flex mt-3" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn draw-border text-white" type="submit">Search</button>
        </form> -->
      </div>
    </div>
  </div>
</nav>