@extends('Partials.dashboard-template-main')
@section('dashboard-content')
<div class="pagetitle">
    <h1>Data Kategori</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item">Barang</li>
        <li class="breadcrumb-item active">Kategori</li>
      </ol>
    </nav>
</div>
<div class="create-button">
    <a href="{{ route('kategori-create-page') }}" class="btn btn-primary mb-3"> <i class="bi bi-file-earmark-plus"></i>  Kategori Baru</a>
</div>
<div class="card">
    <div class="card-body">
        <table class="table datatable">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
               @foreach($kategoris as $kategori)
               <tr>
                   <td>{{ $loop->iteration }}</td>
                   <td>{{ $kategori->Nama_Kategori }}</td>
                   <td>
                     <!-- Tombol Edit dengan Modal -->
                     <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $kategori->ID_Kategori }}">
                         Edit
                     </button>

                     <!-- Tombol untuk hapus -->
                     <form action="{{ route('kategori-delete', ['id'=>$kategori->ID_Kategori]) }}" method="POST" style="display:inline;">
                         @csrf
                         @method('DELETE')
                         <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah kamu yakin ingin menghapus kategori ini?')">Hapus</button>
                     </form>
                   </td>
               </tr>

               <!-- Modal Edit -->
               <div class="modal fade" id="editModal-{{ $kategori->ID_Kategori }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                   <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <h5 class="modal-title" id="editModalLabel">Edit Kategori</h5>
                               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <form action="{{ route('kategori-update', ['id'=>$kategori->ID_Kategori]) }}" method="POST">
                               @csrf
                               @method('PUT')
                               <div class="modal-body">
                                   <div class="mb-3">
                                       <label for="Nama_Kategori" class="form-label">Nama Kategori</label>
                                       <input type="text" name="Nama_Kategori" value="{{ $kategori->Nama_Kategori }}" class="form-control" required>
                                   </div>
                               </div>
                               <div class="modal-footer">
                                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                   <button type="submit" class="btn btn-success">Simpan</button>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
               @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
