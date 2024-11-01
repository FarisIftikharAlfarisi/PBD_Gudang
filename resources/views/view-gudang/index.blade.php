@extends('Partials.dashboard-template-main')
@section('dashboard-content')
<div class="pagetitle">
    <h1>Data Gudang</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item">Penyimpanan</li>
        <li class="breadcrumb-item active">Gudang</li>
      </ol>
    </nav>
</div>

<!-- Tabel untuk Gudang -->
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Daftar Gudang</h5>
        <table class="table datatable">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Gudang</th>
                <th>Lokasi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
               @foreach($gudangs as $gudang)
               <tr>
                   <td>{{ $loop->iteration }}</td>
                   <td>{{ $gudang->Nama_Gudang }}</td>
                   <td>{{ $gudang->Lokasi }}</td>
                   <td>
                     <!-- Tombol Detail Gudang dengan Modal -->
                     <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailGudangModal-{{ $gudang->ID_Gudang }}">
                         Lihat Detail Gudang
                     </button>
                   </td>
               </tr>

               <!-- Modal Detail Gudang -->
               <div class="modal fade" id="detailGudangModal-{{ $gudang->ID_Gudang }}" tabindex="-1" aria-labelledby="detailGudangModalLabel" aria-hidden="true">
                   <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <h5 class="modal-title" id="detailGudangModalLabel">Detail Gudang</h5>
                               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <div class="modal-body">
                               <p><strong>Nama Gudang:</strong> {{ $gudang->Nama_Gudang }}</p>
                               <p><strong>Lokasi:</strong> {{ $gudang->Lokasi }}</p>
                           </div>
                           <div class="modal-footer">
                               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                           </div>
                       </div>
                   </div>
               </div>
               @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection
