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
  <div class="create-button">
    <a href="{{ route('barang-create-page') }}" class="btn btn-primary mb-3"> <i class="bi bi-file-earmark-plus"></i>  Barang Baru</a>
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
                <th>Harga Pokok</th>
                @if (Auth::guard('karyawan')->user()->Jabatan == 'Owner')
                <th>Harga Jual</th>
                @endif
                <th>Aksi</th>
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
                   @if (Auth::guard('karyawan')->user()->Jabatan == 'Owner')
                       <td> Rp.{{ number_format($barang->Harga_Pokok, 0, ',', '.') }} </td>
                   @endif
                   <td>Rp.{{ number_format($barang->Harga_Jual, 0, ',', '.') }}</td>
                   <td>
                       <!-- Tombol untuk membuka modal -->
                       <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $barang->ID_Barang }}" title="Detail">
                        <i class="bi bi-list-ul"></i>
                       </button>

                       @if (Auth::guard('karyawan')->user()->Jabatan == 'Owner')
                       <!-- Edit Modal Trigger -->
                       <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $barang->ID_Barang }}" title="Edit">
                           <i class="bi bi-pencil-square"></i>
                        </button>

                        <!-- Delete Modal Trigger -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $barang->ID_Barang }}" title="Hapus" >
                            <i class="bi bi-trash3"></i>
                        </button>
                        @endif


                       <!-- Detail Modal -->
                        <div class="modal fade" id="detailModal{{ $barang->ID_Barang }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $barang->ID_Barang }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailModalLabel{{ $barang->ID_Barang }}">Detail Barang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Nama Barang:</strong> {{ $barang->Nama_Barang }}</p>
                                        <p><strong>Kode Part:</strong> {{ $barang->Kode_Part }}</p>
                                        <p><strong>Merek:</strong> {{ $barang->Merek }}</p>
                                        <p><strong>Kategori:</strong> {{ $barang->kategori->Nama_Kategori ?? 'Tidak Ada' }}</p>
                                        <p><strong>Harga:</strong> {{ $barang->Harga_Jual }}</p>
                                        <p><strong>Rak:</strong> {{ $barang->rak->Nomor_Rak ?? 'Tidak Ada' }}</p>
                                        <p><strong>Lokasi Rak:</strong> {{ $barang->rak->Lokasi_Rak ?? 'Tidak Ada' }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $barang->ID_Barang }}" tabindex="-1" aria-labelledby="editModalLabel{{ $barang->ID_Barang }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('barang-update', $barang->ID_Barang) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $barang->ID_Barang }}">Edit Barang</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="Nama_Barang" class="form-label">Nama Barang</label>
                                                <input type="text" class="form-control" name="Nama_Barang" value="{{ $barang->Nama_Barang }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="Kode_Part" class="form-label">Kode Part</label>
                                                <input type="text" class="form-control" name="Kode_Part" value="{{ $barang->Kode_Part }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="Merek" class="form-label">Merek</label>
                                                <input type="text" class="form-control" name="Merek" value="{{ $barang->Merek }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="ID_Kategori" class="form-label">Kategori</label>
                                                <select class="form-select" name="ID_Kategori" required>
                                                    <option value="">Pilih Kategori</option>
                                                    @foreach($kategoris as $kategori)
                                                        <option value="{{ $kategori->ID_Kategori }}" {{ $barang->ID_Kategori == $kategori->ID_Kategori ? 'selected' : '' }}>
                                                            {{ $kategori->Nama_Kategori }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="ID_Rak" class="form-label">Rak</label>
                                                <select class="form-select" name="ID_Rak" required>
                                                    <option value="">Pilih Rak</option>
                                                    @foreach($raks as $rak)
                                                        <option value="{{ $rak->ID_Rak }}" {{ $barang->ID_Rak == $rak->ID_Rak ? 'selected' : '' }}>
                                                            {{ $rak->Nomor_Rak }} - {{ $rak->Lokasi_Rak }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="Harga_Jual" class="form-label">Harga</label>
                                                <input type="number" class="form-control" name="Harga_Jual" value="{{ $barang->Harga_Jual }}" required>
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

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal{{ $barang->ID_Barang }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $barang->ID_Barang }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('barang-delete', $barang->ID_Barang) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $barang->ID_Barang }}">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus barang <strong>{{ $barang->Nama_Barang }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </div>
                                    </form>
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
