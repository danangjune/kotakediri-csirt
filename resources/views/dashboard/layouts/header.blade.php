<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow justify-content-between">
  <div class="container-fluid">
    @foreach ($profils->take(1) as $profil)
      <a class="navbar-brand bg-dark col-md-3 col-lg-2 me-1 px-4 fs-6" href="/"><strong>{{ $profil->name }}</strong></a>
    @endforeach
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="form-control-dark w-100"></div>

    <div class="navbar-dark" style="margin-right: 6rem">
        @auth
        <ul class="text-decoration-none m-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white fs-6" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <strong>{{ auth()->user()->name }}</strong>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item py-1" href="/register/showChangePasswordGet">Change Password <span data-feather="key"></span></a></li>              
              <li>
                <form action="/logout" method="post">
                  @csrf
                  <button type="submit" class="dropdown-item nav-link text-dark px-3 border-0">Logout <span data-feather="log-out"></span></button>
                </form>
              </li>
          </li>
        </ul>
        @endauth
    </div>
  </div>
</header>