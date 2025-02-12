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
<div class="create-button">
    <a href="{{ route('gudang-create-page') }}" class="btn btn-primary mb-3"> <i class="bi bi-file-earmark-plus"></i>  Gudang Baru</a>
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
                        <i class="bi bi-list-ul"></i> 
                     </button>

                     <!-- Tombol Edit Gudang dengan Modal -->
                     <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editGudangModal-{{ $gudang->ID_Gudang }}">
                        <i class="bi bi-pencil-square"></i>
                     </button>

                     <!-- Tombol Hapus Gudang dengan Modal -->
                     <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteGudangModal-{{ $gudang->ID_Gudang }}">
                         <i class="bi bi-trash3"></i>
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

               <!-- Modal Edit Gudang -->
               <div class="modal fade" id="editGudangModal-{{ $gudang->ID_Gudang }}" tabindex="-1" aria-labelledby="editGudangModalLabel" aria-hidden="true">
                   <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <h5 class="modal-title" id="editGudangModalLabel">Edit Gudang</h5>
                               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <div class="modal-body">
                               <form action="{{ route('gudang-update', $gudang->ID_Gudang) }}" method="POST">
                                   @csrf
                                   @method('PUT')
                                   <div class="mb-3">
                                       <label for="Nama_Gudang" class="form-label">Nama Gudang</label>
                                       <input type="text" name="Nama_Gudang" class="form-control" value="{{ $gudang->Nama_Gudang }}" required>
                                   </div>
                                   <div class="mb-3">
                                       <label for="Lokasi" class="form-label">Lokasi</label>
                                       <input type="text" name="Lokasi" class="form-control" value="{{ $gudang->Lokasi }}" required>
                                   </div>
                                   <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                               </form>
                           </div>
                       </div>
                   </div>
               </div>

               <!-- Modal Delete Gudang -->
               <div class="modal fade" id="deleteGudangModal-{{ $gudang->ID_Gudang }}" tabindex="-1" aria-labelledby="deleteGudangModalLabel" aria-hidden="true">
                   <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <h5 class="modal-title" id="deleteGudangModalLabel">Hapus Gudang</h5>
                               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <div class="modal-body">
                               <p>Apakah Anda yakin ingin menghapus gudang <strong>{{ $gudang->Nama_Gudang }}</strong>?</p>
                           </div>
                           <div class="modal-footer">
                               <form action="{{ route('gudang-delete', $gudang->ID_Gudang) }}" method="POST">
                                   @csrf
                                   @method('DELETE')
                                   <button type="submit" class="btn btn-danger">Hapus</button>
                               </form>
                               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
