<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">

    <!--Kasir-->
    @if (Auth::guard('karyawan')->user()->Jabatan == 'Staff')
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'kasir-index-page' ? 'active' : 'collapsed' }}" href="{{ route('kasir-index-page') }}">
            <i class="bi bi-cart4"></i><span>Pemesanan</span>
        </a>
    </li>

    {{-- Barang --}}
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'barang-index-page' ? 'active' : 'collapsed' }}" href="{{ route('barang-index-page') }}">
            <i class="bi bi-upc"></i><span>Barang</span>
          </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'riwayat-pembelian-kasir' ? 'active' : 'collapsed' }}" href="{{ route('riwayat-pembelian-kasir') }}">
            <i class="bi bi-receipt"></i><span>Riwayat Pembelian</span>
          </a>
    </li>
    @endif
    <!--End Kasir-->

    @if(Auth::guard('karyawan')->user()->Jabatan == 'Owner') <!--Hak akses Owner : Analisis Penjualan -->

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'analisis' ? 'active' : 'collapsed' }}" href="{{ route('analisis') }}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>
    </li>

    {{-- <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'tanya-gpt' ? 'active' : 'collapsed' }}" href="{{ route('tanya-gpt') }}">
            <i class="bi bi-slack"></i>
            <span>JadiGPT</span>
        </a>
    </li> --}}

      <!-- Supplier -->
    <li class="nav-item">
        <a class="nav-link {{ in_array(Route::currentRouteName(), ['supplier-index-page', 'supplier-create-page']) ? 'active' : 'collapsed' }}" href="{{ route('supplier-index-page') }}">
          <i class="bi bi-person-lines-fill"></i>
          <span>Supplier</span>
        </a>
      </li>

    <!-- Karyawan -->
    <li class="nav-item">
      <a class="nav-link {{ in_array(Route::currentRouteName(), ['karyawan-index-page', 'karyawan-create-page']) ? 'active' : 'collapsed' }}" href="{{ route('karyawan-index-page') }}">
        <i class="bi bi-person-badge"></i>
        <span>Karyawan</span>
      </a>
    </li>
    @endif

     {{-- owner & manager --}}
    @if (Auth::guard('karyawan')->user()->Jabatan == 'Owner' || Auth::guard('karyawan')->user()->Jabatan == 'Manager')
     <!-- Barang -->
     <li class="nav-item">
        <a class="nav-link {{ in_array(Route::currentRouteName(), ['barang-index-page', 'barang-create-page','kategori-index-page', 'kategori-create-page']) ? '' : 'collapsed' }}" data-bs-target="#components-nav-barang" data-bs-toggle="collapse" href="#">
          <i class="bi bi-upc"></i><span>Barang</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav-barang" class="nav-content collapse {{ in_array(Route::currentRouteName(), ['barang-index-page', 'barang-create-page', 'kategori-index-page', 'kategori-create-page']) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'barang-index-page' || Route::currentRouteName() == 'barang-create-page' ? 'active' : '' }}" href="{{ route('barang-index-page') }}">
              <i class="bi bi-circle"></i><span>Barang</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'kategori-index-page' || Route::currentRouteName() == 'kategori-create-page' ? 'active' : '' }}" href="{{ route('kategori-index-page') }}">
              <i class="bi bi-circle"></i><span>Kategori Barang</span>
            </a>
          </li>
        </ul>
      </li>

    <!-- Pengeluaran -->
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'pengeluaran-index-page' ? 'active' : 'collapsed' }}" href="{{ route('pengeluaran-index-page') }}">
          <i class="bi bi-box-seam"></i><span>Pengeluaran</span>
        </a>
      </li>
    @endif

     <!-- Penerimaan -->
     <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'penerimaan-index-page' ? 'active' : 'collapsed' }}" href="{{ route('penerimaan-index-page') }}">
          <i class="bi bi-truck"></i><span>Penerimaan</span>
        </a>
      </li>

      <!-- Penyimpanan -->
    <li class="nav-item">
        <a class="nav-link {{ in_array(Route::currentRouteName(), ['gudang-index-page', 'gudang-create-page','rak-index-page', 'rak-create-page']) ? '' : 'collapsed' }}" data-bs-target="#components-nav-penyimpanan" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Penyimpanan</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav-penyimpanan" class="nav-content collapse {{ in_array(Route::currentRouteName(), ['gudang-index-page', 'gudang-create-page', 'rak-index-page', 'rak-create-page']) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'gudang-index-page' || Route::currentRouteName() == 'gudang-create-page' ? 'active' : '' }}" href="{{ route('gudang-index-page') }}">
              <i class="bi bi-circle"></i><span>Gudang</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'rak-index-page' || Route::currentRouteName() == 'rak-create-page' ? 'active' : '' }}" href="{{ route('rak-index-page') }}">
              <i class="bi bi-circle"></i><span>Rak</span>
            </a>
          </li>
        </ul>
      </li>


    {{-- end owner & Manager --}}

  </ul>
</aside>
