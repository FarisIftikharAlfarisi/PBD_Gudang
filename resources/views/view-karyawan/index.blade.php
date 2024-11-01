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
                     <!-- Tombol Detail dengan Modal -->
                     <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal-{{ $karyawan->ID_Karyawan }}">
                         Lihat Detail
                     </button>
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
               @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
