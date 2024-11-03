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
            <th>Barang</th>
            <th>Jumlah</th>
            <th data-type="date" data-format="DD/MM/YYYY">Tanggal Transaksi</th>
          </tr>
        </thead>
        @foreach ($pengeluarans as $pengeluaran)
        <tr>
            <td>{{ $pengeluaran->No_Faktur }}</td>
            <td>{{ $pengeluaran->Nama_Penerima }}</td>
            <td>{{ $pengeluaran->Tujuan }}</td>
            <td>{{ $pengeluaran->barang->Nama_Barang }}</td>
            <td>{{ $pengeluaran->Jumlah }}</td>
            <td>{{ $pengeluaran->Tanggal_Pengeluaran }}</td>
        </tr>
        @endforeach
      </table>
      <!-- End Table with stripped rows -->

    </div>
  </div>
@endsection
