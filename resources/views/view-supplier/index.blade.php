@extends('Partials.dashboard-template-main')
@section('dashboard-content')
<div class="pagetitle">
    <h1>Data Supplier</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Supplier</li>
      </ol>
    </nav>
</div>
<div class="create-button">
    <a href="{{ route('supplier-create-page') }}" class="btn btn-primary mb-3"> <i class="bi bi-file-earmark-plus"></i>  Supplier Baru</a>
</div>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Daftar Supplier</h5>
        <table class="table datatable">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Supplier</th>
                <th>Nomor Telepon</th>
                <th>Email</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
               @foreach($suppliers as $supplier)
               <tr>
                   <td>{{ $loop->iteration }}</td>
                   <td>{{ $supplier->Nama_Supplier }}</td>
                   <td>{{ $supplier->Nomor_Telepon }}</td>
                   <td>{{ $supplier->Email }}</td>
                   <td>
                     <!-- Tombol Detail dengan Modal -->
                     <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailSupplierModal-{{ $supplier->ID_Supplier }}">
                        <i class="bi bi-list-ul"></i> 
                     </button>

                     <!-- Tombol Edit dengan Modal -->
                     <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSupplierModal-{{ $supplier->ID_Supplier }}">
                        <i class="bi bi-pencil-square"></i>
                     </button>

                     <!-- Tombol Hapus dengan Modal -->
                     <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteSupplierModal-{{ $supplier->ID_Supplier }}">
                        <i class="bi bi-trash3"></i>
                     </button>
                   </td>
               </tr>

               <!-- Modal Detail Supplier -->
               <div class="modal fade" id="detailSupplierModal-{{ $supplier->ID_Supplier }}" tabindex="-1" aria-labelledby="detailSupplierModalLabel" aria-hidden="true">
                   <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <h5 class="modal-title" id="detailSupplierModalLabel">Detail Supplier</h5>
                               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <div class="modal-body">
                               <p><strong>Nama Supplier:</strong> {{ $supplier->Nama_Supplier }}</p>
                               <p><strong>Alamat:</strong> {{ $supplier->Alamat }}</p>
                               <p><strong>Nomor Telepon:</strong> {{ $supplier->Nomor_Telepon }}</p>
                               <p><strong>Email:</strong> {{ $supplier->Email }}</p>
                               <p><strong>Spesialisasi:</strong> {{ $supplier->Spesialisasi }}</p>
                           </div>
                           <div class="modal-footer">
                               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                           </div>
                       </div>
                   </div>
               </div>

               <!-- Modal Edit Supplier -->
               <div class="modal fade" id="editSupplierModal-{{ $supplier->ID_Supplier }}" tabindex="-1" aria-labelledby="editSupplierModalLabel" aria-hidden="true">
                   <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <h5 class="modal-title" id="editSupplierModalLabel">Edit Supplier</h5>
                               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <div class="modal-body">
                               <form action="{{ route('suppliers.update', $supplier->ID_Supplier) }}" method="POST">
                                   @csrf
                                   @method('PUT')
                                   <div class="mb-3">
                                       <label for="Nama_Supplier" class="form-label">Nama Supplier</label>
                                       <input type="text" class="form-control" id="Nama_Supplier" name="Nama_Supplier" value="{{ $supplier->Nama_Supplier }}" required>
                                   </div>
                                   <div class="mb-3">
                                       <label for="Alamat" class="form-label">Alamat</label>
                                       <textarea class="form-control" id="Alamat" name="Alamat" rows="2" required>{{ $supplier->Alamat }}</textarea>
                                   </div>
                                   <div class="mb-3">
                                       <label for="Nomor_Telepon" class="form-label">Nomor Telepon</label>
                                       <input type="text" class="form-control" id="Nomor_Telepon" name="Nomor_Telepon" value="{{ $supplier->Nomor_Telepon }}" required>
                                   </div>
                                   <div class="mb-3">
                                       <label for="Email" class="form-label">Email</label>
                                       <input type="email" class="form-control" id="Email" name="Email" value="{{ $supplier->Email }}" required>
                                   </div>
                                   <div class="mb-3">
                                       <label for="Spesialisasi" class="form-label">Spesialisasi</label>
                                       <input type="text" class="form-control" id="Spesialisasi" name="Spesialisasi" value="{{ $supplier->Spesialisasi }}" required>
                                   </div>
                                   <div class="modal-footer">
                                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                       <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                   </div>
                               </form>
                           </div>
                       </div>
                   </div>
               </div>

               <!-- Modal Delete Supplier -->
               <div class="modal fade" id="deleteSupplierModal-{{ $supplier->ID_Supplier }}" tabindex="-1" aria-labelledby="deleteSupplierModalLabel" aria-hidden="true">
                   <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <h5 class="modal-title" id="deleteSupplierModalLabel">Hapus Supplier</h5>
                               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <div class="modal-body">
                               <p>Apakah Anda yakin ingin menghapus supplier <strong>{{ $supplier->Nama_Supplier }}</strong>?</p>
                           </div>
                           <div class="modal-footer">
                               <form action="{{ route('suppliers.destroy', $supplier->ID_Supplier) }}" method="POST">
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
