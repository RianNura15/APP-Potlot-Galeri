<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="{{route('blog.index')}}">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    @auth
      <li class="nav-item nav-category">Pemesanan Saya</li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
          <i class="menu-icon mdi mdi-card-text-outline"></i>
          <span class="menu-title">Custom Lukisan</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="form-elements">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="{{route('blog.custom.index')}}">Pesan Ke Pelukis</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('blog.custom.data_list')}}">Draf Pesanan</a></li>
          </ul>
        </div>
      </li>
    @endauth
  </ul>
</nav>
<!-- partial -->
