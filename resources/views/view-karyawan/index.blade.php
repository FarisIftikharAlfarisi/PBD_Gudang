@extends('Partials.dashboard-template-main')
@section('dashboard-content')
<div class="pagetitle">
    <h1>Data Karyawan</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item">Karyawan</li>
        <li class="breadcrumb-item active">Data Karyawan</li>
      </ol>
    </nav>
</div>
<div class="create-button">
    <a href="{{ route('karyawan-create-page') }}" class="btn btn-primary mb-3"> <i class="bi bi-file-earmark-plus"></i>  Karyawan Baru</a>
</div>
<div class="card">
    <div class="card-body">
        <table class="table datatable">
            <thead>
              <tr>
                <th>#</th>
                <th>Nomor Karyawan</th>
                <th>Nama Karyawan</th>
                <th>Jabatan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
               @foreach($karyawans as $karyawan)
               <tr>
                   <td>{{ $loop->iteration }}</td>
                   <td>{{ $karyawan->Nomor_karyawan }}</td>
                   <td>{{ $karyawan->Nama_Karyawan }}</td>
                   <td>{{ $karyawan->Jabatan }}</td>
                   <td>
                     <!-- Tombol Detail -->
                     <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal-{{ $karyawan->ID_Karyawan }}">
                         Lihat Detail
                     </button>
                     
                     <!-- Tombol Edit -->
                     <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $karyawan->ID_Karyawan }}">
                         Edit
                     </button>

                     <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $karyawan->ID_Karyawan }}">
                        Hapus
                    </button>
                  </td>
                   </td>
               </tr>

               <!-- Modal Detail -->
               <div class="modal fade" id="detailModal-{{ $karyawan->ID_Karyawan }}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                   <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <h5 class="modal-title" id="detailModalLabel">Detail Karyawan</h5>
                               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <div class="modal-body">
                               <p><strong>Nomor Karyawan:</strong> {{ $karyawan->Nomor_karyawan }}</p>
                               <p><strong>Nama Karyawan:</strong> {{ $karyawan->Nama_Karyawan }}</p>
                               <p><strong>Email:</strong> {{ $karyawan->email }}</p>
                               <p><strong>Alamat:</strong> {{ $karyawan->Alamat }}</p>
                               <p><strong>Nomor Telepon:</strong> {{ $karyawan->Nomor_Telepon }}</p>
                               <p><strong>Jabatan:</strong> {{ $karyawan->Jabatan }}</p>
                           </div>
                           <div class="modal-footer">
                               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                           </div>
                       </div>
                   </div>
               </div>

               <!-- Modal Edit -->
               <div class="modal fade" id="editModal-{{ $karyawan->ID_Karyawan }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                   <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <h5 class="modal-title" id="editModalLabel">Edit Karyawan</h5>
                               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <form action="{{ route('karyawan-update', $karyawan->ID_Karyawan) }}" method="POST">
                               @csrf
                               @method('PUT')
                               <div class="modal-body">
                                   <div class="mb-3">
                                       <label for="Nomor_karyawan" class="form-label">Nomor Karyawan</label>
                                       <input type="text" class="form-control" id="Nomor_karyawan" name="Nomor_karyawan" value="{{ $karyawan->Nomor_karyawan }}" required>
                                   </div>
                                   <div class="mb-3">
                                       <label for="Nama_Karyawan" class="form-label">Nama Karyawan</label>
                                       <input type="text" class="form-control" id="Nama_Karyawan" name="Nama_Karyawan" value="{{ $karyawan->Nama_Karyawan }}" required>
                                   </div>
                                   <div class="mb-3">
                                       <label for="email" class="form-label">Email</label>
                                       <input type="email" class="form-control" id="email" name="email" value="{{ $karyawan->email }}" required>
                                   </div>
                                   <div class="mb-3">
                                       <label for="Alamat" class="form-label">Alamat</label>
                                       <input type="text" class="form-control" id="Alamat" name="Alamat" value="{{ $karyawan->Alamat }}" required>
                                   </div>
                                   <div class="mb-3">
                                       <label for="Nomor_Telepon" class="form-label">Nomor Telepon</label>
                                       <input type="text" class="form-control" id="Nomor_Telepon" name="Nomor_Telepon" value="{{ $karyawan->Nomor_Telepon }}" required>
                                   </div>
                                   <div class="mb-3">
                                       <label for="Jabatan" class="form-label">Jabatan</label>
                                       <input type="text" class="form-control" id="Jabatan" name="Jabatan" value="{{ $karyawan->Jabatan }}" required>
                                   </div>
                                   <div class="mb-3">
                                       <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                                       <input type="password" class="form-control" id="password" name="password">
                                   </div>
                               </div>
                               <div class="modal-footer">
                                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                   <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>

               <!-- Modal Hapus -->
               <div class="modal fade" id="deleteModal-{{ $karyawan->ID_Karyawan }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Hapus Karyawan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus karyawan ini?
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('karyawan-delete', $karyawan->ID_Karyawan) }}" method="POST">
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
