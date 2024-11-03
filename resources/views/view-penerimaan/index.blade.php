@extends('Partials.dashboard-template-main')
@section('dashboard-content')
<div class="pagetitle">
    <h1>Data Penerimaan Barang</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Penerimaan</li>
      </ol>
    </nav>
</div>
<div class="create-button">
    <a href="{{ route('penerimaan-create-page') }}" class="btn btn-primary mb-3"> <i class="bi bi-file-earmark-plus"></i>  Penerimaan Baru</a>
</div>
<div class="card">
    <div class="card-body">
      <h5 class="card-title">Data Penerimaan Barang Dari Supplier</h5>
      {{-- <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable. Check for <a href="https://fiduswriter.github.io/simple-datatables/demos/" target="_blank">more examples</a>.</p> --}}

      <!-- Table with stripped rows -->
      <table class="table datatable">
        <thead>
          <tr>
            <th>No.Faktur</th>
            <th>Supplier</th>
            <th>Barang</th>
            <th>Jumlah Pengiriman</th>
            <th data-type="date" data-format="DD/MM/YYYY">Tanggal Masuk</th>
          </tr>
        </thead>
        @foreach ($penerimaans as $penerimaan)
        <tr>
            <td>{{ $penerimaan->No_Faktur }}</td>
            <td>{{ $penerimaan->supplier->Nama_Supplier }}</td>
            <td>{{ $penerimaan->barang->Nama_Barang }}</td>
            <td>{{ $penerimaan->Jumlah }}</td>
            <td>{{ $penerimaan->Tanggal_Penerimaan }}</td>
        </tr>
        @endforeach
      </table>
      <!-- End Table with stripped rows -->

    </div>
  </div>
@endsection
