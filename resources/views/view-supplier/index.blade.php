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
                         Lihat Detail
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
               @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
