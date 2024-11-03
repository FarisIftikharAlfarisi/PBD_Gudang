@extends('Partials.dashboard-template-main')
@section('dashboard-content')
<div class="pagetitle">
    <h1>  Data Barang </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Barang</li>
      </ol>
    </nav>
  </div>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Daftar Barang</h5>
        <table class="table datatable">
            <thead>
              <tr>
                <th>#</th>
                <th>Kode Part</th>
                <th>Merek</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Detail</th>
              </tr>
            </thead>
            <tbody>
               @foreach($barangs as $barang)
               <tr>
                   <td>{{ $loop->iteration }}</td>
                   <td>{{ $barang->Kode_Part }}</td>
                   <td>{{ $barang->Merek }}</td>
                   <td>{{ $barang->Nama_Barang}}</td>
                   <td>{{ $barang->inventaris->Jumlah_Barang_Aktual ?? 'Tidak Ada' }}</td>
                   <td>{{ $barang->Harga_Jual }}</td>
                   <td>
                       <!-- Tombol untuk membuka modal -->
                       <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $barang->id }}">
                           Lihat Detail
                       </button>

                       <!-- Modal -->
                       <div class="modal fade" id="detailModal{{ $barang->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $barang->id }}" aria-hidden="true">
                           <div class="modal-dialog">
                               <div class="modal-content">
                                   <div class="modal-header">
                                       <h5 class="modal-title" id="detailModalLabel{{ $barang->id }}">Detail Barang</h5>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                   </div>
                                   <div class="modal-body">
                                       <p><strong>Nama Barang:</strong> {{ $barang->Nama_Barang }}</p>
                                       <p><strong>Kode Part:</strong> {{ $barang->Kode_Part }}</p>
                                       <p><strong>Merek:</strong> {{ $barang->Merek }}</p>
                                       <p><strong>Kategori:</strong> {{ $barang->kategori->Nama_Kategori }}</p>
                                       <p><strong>Harga:</strong> {{ $barang->Harga_Jual }}</p>
                                       <p><strong>Rak</strong> {{ $barang->rak->Nomor_Rak }}</p>
                                       <p><strong>Lokasi Rak</strong> {{ $barang->rak->Lokasi_Rak }}</p>
                                   </div>
                                   <div class="modal-footer">
                                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </td>
               </tr>
               @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
