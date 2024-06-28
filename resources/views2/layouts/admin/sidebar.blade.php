<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Galeri Potlot</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    @if (auth()->user()->role == 'admin')
      <li class="nav-item active">
        <a class="nav-link" href="{{route('admin.home')}}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
        </li>
        <hr class="sidebar-divider">

        <div class="sidebar-heading">
          Master Data
        </div>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
          aria-expanded="true" aria-controls="collapseTwo">
          <i class="fa fa-user" aria-hidden="true"></i>
          <span>User</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('admin.user.anggota')}}">Anggota</a>
            <a class="collapse-item" href="{{route('admin.customer.customer_index')}}">Customer</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Produk Menu
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-folder"></i>
        <span>Karya</span>
      </a>
      <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item" href="{{route('admin.karya.index')}}">List Data</a>
          <a class="collapse-item" href="{{route('admin.karya.tambah_index')}}">Tambah Lukisan</a>
          <a class="collapse-item" href="{{route('admin.promo.index')}}">Harga Promo</a>
        </div>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#transaksiCollapse"
      aria-expanded="true" aria-controls="transaksiCollapse">
      <i class="fas fa-fw fa-shopping-cart" aria-hidden="true"></i>
      <span>Transaksi</span>
    </a>
    <div id="transaksiCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{route('admin.user.anggota')}}">Penjualan</a>
      </div>
    </div>
    </li>
  @elseif (auth()->user()->role == 'anggota')
    <li class="nav-item active">
      <a class="nav-link" href="index.html">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
      aria-expanded="true" aria-controls="collapsePages">
      <i class="fas fa-fw fa-folder"></i>
      <span>Karya</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{route('marketing.gambar.index')}}">List Data</a>
        <a class="collapse-item" href="{{route('marketing.gambar.tambah_index')}}">Tambah Lukisan</a>
        <a class="collapse-item" href="{{route('marketing.gambar.index_promo')}}">Harga Promo</a>
      </div>
    </div>
  </li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#colapsePembayaran"
      aria-expanded="true" aria-controls="colapsePembayaran">
      <i class="fas fa-fw fa-folder"></i>
      <span>Transaksi</span>
    </a>
    <div id="colapsePembayaran" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{route('marketing.transaksi.index')}}">List Data</a>
      </div>
    </div>
  </li>
  {{-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pesananCollapse"
    aria-expanded="true" aria-controls="pesananCollapse">
    <i class="fas fa-fw fa-folder"></i>
    <span>Custom</span>
  </a>
    <div id="pesananCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{route('marketing.pembayaran.index')}}">Pesanan</a>
        <a class="collapse-item" href="{{route('marketing.pembayaran.index')}}">Revisi</a>
      </div>
    </div>
  </li> --}}
    @endif
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
