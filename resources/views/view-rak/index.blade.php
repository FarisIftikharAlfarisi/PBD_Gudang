@extends('Partials.dashboard-template-main')
@section('dashboard-content')
<div class="pagetitle">
    <h1>Data Gudang</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item ">Penyimpanan</li>
        <li class="breadcrumb-item active">Rak</li>
      </ol>
    </nav>
</div>
<!-- Tabel untuk Rak -->
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Daftar Rak</h5>
        <table class="table datatable">
            <thead>
              <tr>
                <th>#</th>
                <th>Nomor Rak</th>
                <th>Lokasi Rak</th>
                <th>Kapasitas Rak</th>
                <th>Status Rak</th>
                <th>Gudang</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
               @foreach($raks as $rak)
               <tr>
                   <td>{{ $loop->iteration }}</td>
                   <td>{{ $rak->Nomor_Rak }}</td>
                   <td>{{ $rak->Lokasi_Rak }}</td>
                   <td>{{ $rak->Kapasitas_Rak }}</td>
                   <td>{{ $rak->Status_Rak }}</td>
                   <td>{{ $rak->gudang->Nama_Gudang }}</td> <!-- Relasi Gudang -->
                   <td>
                     <!-- Tombol Detail Rak dengan Modal -->
                     <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailRakModal-{{ $rak->ID_Rak }}">
                         Lihat Detail Rak
                     </button>
                   </td>
               </tr>

               <!-- Modal Detail Rak -->
               <div class="modal fade" id="detailRakModal-{{ $rak->ID_Rak }}" tabindex="-1" aria-labelledby="detailRakModalLabel" aria-hidden="true">
                   <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <h5 class="modal-title" id="detailRakModalLabel">Detail Rak</h5>
                               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <div class="modal-body">
                               <p><strong>Nomor Rak:</strong> {{ $rak->Nomor_Rak }}</p>
                               <p><strong>Lokasi Rak:</strong> {{ $rak->Lokasi_Rak }}</p>
                               <p><strong>Kapasitas Rak:</strong> {{ $rak->Kapasitas_Rak }}</p>
                               <p><strong>Status Rak:</strong> {{ $rak->Status_Rak }}</p>
                               <p><strong>Gudang:</strong> {{ $rak->gudang->Nama_Gudang }}</p>
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
