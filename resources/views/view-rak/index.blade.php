@extends('Partials.dashboard-template-main')
@section('dashboard-content')
<div class="pagetitle">
    <h1>Data Gudang</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item">Penyimpanan</li>
        <li class="breadcrumb-item active">Rak</li>
      </ol>
    </nav>
</div>
<div class="create-button">
    <a href="{{ route('rak-create-page') }}" class="btn btn-primary mb-3"> <i class="bi bi-file-earmark-plus"></i>  Rak Baru</a>
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
                   <td>{{ $rak->gudang->Nama_Gudang }}</td>
                   <td>
                     <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailRakModal-{{ $rak->ID_Rak }}">
                         Lihat Detail
                     </button>
                     <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRakModal-{{ $rak->ID_Rak }}">
                         Edit
                     </button>
                     <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteRakModal-{{ $rak->ID_Rak }}">
                         Hapus
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

               <!-- Modal Edit Rak -->
                <div class="modal fade" id="editRakModal-{{ $rak->ID_Rak }}" tabindex="-1" aria-labelledby="editRakModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editRakModalLabel">Edit Rak</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('rak-update', $rak->ID_Rak) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="Nomor_Rak" class="form-label">Nomor Rak</label>
                                        <input type="text" name="Nomor_Rak" class="form-control" value="{{ $rak->Nomor_Rak }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Lokasi_Rak" class="form-label">Lokasi Rak</label>
                                        <input type="text" name="Lokasi_Rak" class="form-control" value="{{ $rak->Lokasi_Rak }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Kapasitas_Rak" class="form-label">Kapasitas Rak</label>
                                        <input type="number" name="Kapasitas_Rak" class="form-control" value="{{ $rak->Kapasitas_Rak }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Status_Rak" class="form-label">Status Rak</label>
                                        <select name="Status_Rak" class="form-select" required>
                                            <option value="Aktif" {{ $rak->Status_Rak == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="Tidak Aktif" {{ $rak->Status_Rak == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ID_Gudang" class="form-label">Gudang</label>
                                        <select name="ID_Gudang" class="form-select" required>
                                            @foreach($gudangs as $gudang)
                                                <option value="{{ $gudang->ID_Gudang }}" {{ $rak->ID_Gudang == $gudang->ID_Gudang ? 'selected' : '' }}>
                                                    {{ $gudang->Nama_Gudang }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
 
                <!-- Modal Hapus Rak -->
                <div class="modal fade" id="deleteRakModal-{{ $rak->ID_Rak }}" tabindex="-1" aria-labelledby="deleteRakModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteRakModalLabel">Hapus Rak</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah Anda yakin ingin menghapus rak <strong>{{ $rak->Nomor_Rak }}</strong>? Tindakan ini tidak dapat dibatalkan.</p>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('rak-delete', $rak->ID_Rak) }}" method="POST">
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
             </tbody>
         </table>
     </div>
 </div>
 @endsection