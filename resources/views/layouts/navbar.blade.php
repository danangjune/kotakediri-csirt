<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
      <a class="navbar-brand" href="/">
          @foreach ($properties->take(1) as $property)
            <img class="logo" src="{{ asset('storage/' . $property->image) }}" alt="{{ $property->property }}">
          @endforeach    
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse text-white" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('profil') ? 'active' : '' }}" href="/profil">Profil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('posts') ? 'active' : '' }}" href="/posts">Artikel</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('file') ? 'active' : '' }}" href="/file">RFC2350</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('service') ? 'active' : '' }}" href="/service">Layanan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('guidance') ? 'active' : '' }}" href="/guidance">Panduan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('contact') ? 'active' : '' }}" href="/contact">Kontak</a>
          </li>
        </ul>
      </div>
    </div>
</nav>
<!-- End Navigation Bar -->