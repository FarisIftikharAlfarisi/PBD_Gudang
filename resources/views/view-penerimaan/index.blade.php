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
    <a href="{{ route('penerimaan-create-page') }}" class="btn btn-primary mb-3"> <i class="bi bi-file-earmark-plus"></i> Penerimaan Baru</a>
</div>
<div class="card">
    <div class="card-body">
      <h5 class="card-title">Data Penerimaan Barang Dari Supplier</h5>
      <table class="table datatable">
        <thead>
          <tr>
            <th>No.Faktur</th>
            <th>Supplier</th>
            <th>Jumlah Jenis Barang</th>
            <th>Tanggal Masuk</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($penerimaans as $penerimaan)
        <tr>
            <td>{{ $penerimaan->No_Faktur }}</td>
            <td>{{ $penerimaan->supplier->Nama_Supplier }}</td>
            <td>{{ $penerimaan->jumlah_jenis_barang }}</td> <!-- Ganti sesuai nama atribut yang menghitung jumlah jenis barang -->
            <td>{{ $penerimaan->Tanggal_Penerimaan }}</td>
            <td>
                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $penerimaan->ID_Penerimaan }}">
                    Detail
                </button>
                <a href="{{ route('penerimaan-edit-page', $penerimaan->ID_Penerimaan) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $penerimaan->ID_Penerimaan }}">
                    Hapus
                </button>
            </td>
        </tr>
        @endforeach
        </tbody>
      </table>
    </div>
</div>

<!-- Modals -->
@foreach ($penerimaans as $penerimaan)
<div class="modal fade" id="detailModal{{ $penerimaan->ID_Penerimaan }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $penerimaan->ID_Penerimaan }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel{{ $penerimaan->ID_Penerimaan }}">Detail Barang - No Faktur {{ $penerimaan->No_Faktur }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($penerimaan->details as $detail)
                    <tr>
                        <td>{{ $detail->barang->Nama_Barang }}</td>
                        <td>{{ $detail->qty }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endforeach
@foreach ($penerimaans as $penerimaan)
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal{{ $penerimaan->ID_Penerimaan }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $penerimaan->ID_Penerimaan }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $penerimaan->ID_Penerimaan }}">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus penerimaan dengan No Faktur <strong>{{ $penerimaan->No_Faktur }}</strong>?
            </div>
            <div class="modal-footer">
                <form action="{{ route('penerimaan-delete', $penerimaan->ID_Penerimaan) }}" method="POST">
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
