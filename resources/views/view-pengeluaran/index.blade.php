@extends('Partials.dashboard-template-main')
@section('dashboard-content')
<div class="pagetitle">
    <h1>Data Pengeluaran Barang</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Pengeluaran</li>
      </ol>
    </nav>
</div>
<div class="create-button">
    <a href="{{ route('pengeluaran-create-page') }}" class="btn btn-primary mb-3"> <i class="bi bi-file-earmark-plus"></i>  Pengiriman Baru</a>
</div>
<div class="card">
    <div class="card-body">
      <h5 class="card-title">Data Pengiriman Barang Kepada Pelanggan</h5>
      {{-- <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable. Check for <a href="https://fiduswriter.github.io/simple-datatables/demos/" target="_blank">more examples</a>.</p> --}}

      <!-- Table with stripped rows -->
      <table class="table datatable">
        <thead>
          <tr>
            <th>No.Faktur</th>
            <th>Penerima</th>
            <th>Alamat</th>
            <th data-type="date" data-format="DD/MM/YYYY">Tanggal Transaksi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        @foreach ($pengeluarans as $pengeluaran)
        <tr>
            <td>{{ $pengeluaran->No_Faktur }}</td>
            <td>{{ $pengeluaran->Nama_Penerima }}</td>
            <td>{{ $pengeluaran->Tujuan }}</td>
            <td>{{ $pengeluaran->Tanggal_Pengeluaran }}</td>
            <td>
              <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $pengeluaran->ID_Pengeluaran }}">
                  <i class="bi bi-list-ul"></i>
              </button>
              <a href="{{ route('pengeluaran-edit-page', $pengeluaran->ID_Pengeluaran) }}" class="btn btn-warning btn-sm">
                  <i class="bi bi-pencil-square"></i>
              </a>
              <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $pengeluaran->ID_Pengeluaran }}">
                  <i class="bi bi-trash3"></i>
              </button>
              <a href="{{ route('pengeluaran-invoice', $pengeluaran->ID_Pengeluaran) }}" class="btn btn-primary btn-sm" target="_blank">
                <i class="bi bi-file-earmark-ruled"></i> Invoice
            </a>
              <a href="{{ route('pengeluaran-surat-jalan', $pengeluaran->ID_Pengeluaran) }}" class="btn btn-primary btn-sm" target="_blank">
                <i class="bi bi-file-earmark-ruled"></i> Surat Jalan
            </a>
          </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>

<!-- Modals -->
@foreach ($pengeluarans as $pengeluaran)
<div class="modal fade" id="detailModal{{ $pengeluaran->ID_Pengeluaran }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $pengeluaran->ID_Pengeluaran }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="detailModalLabel{{ $pengeluaran->ID_Pengeluaran }}">Detail Barang - No Faktur {{ $pengeluaran->No_Faktur }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <table class="table">
                  <thead>
                      <tr>
                          <th>Nama Barang</th>
                          <th>Jumlah</th>
                          <th>Harga</th>
                          <th>Diskon</th>
                          <th>Total</th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($pengeluaran->details as $detail)
                  <tr>
                      <td>{{ $detail->barang->Nama_Barang }}</td>
                      <td>{{ $detail->qty }}</td>
                      <td>{{ $detail->Harga_Jual }}</td>
                      <td>{{ $detail->Diskon }}</td>
                      <td>{{ $detail->Total }}</td>
                  </tr>
                  @endforeach
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>
@endforeach
@foreach ($pengeluarans as $pengeluaran)
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal{{ $pengeluaran->ID_Pengeluaran }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $pengeluaran->ID_Pengeluaran }}" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel{{ $pengeluaran->ID_Pengeluaran }}">Konfirmasi Hapus</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              Apakah Anda yakin ingin menghapus penerimaan dengan No Faktur <strong>{{ $pengeluaran->No_Faktur }}</strong>?
          </div>
          <div class="modal-footer">
              <form action="{{ route('pengeluaran-delete', $pengeluaran->ID_Pengeluaran ) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-danger">Hapus</button>
              </form>
          </div>
      </div>
  </div>
</div>
@endforeach


@endsection

