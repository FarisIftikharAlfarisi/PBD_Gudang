@extends('Partials.dashboard-template-main')

@section('dashboard-content')
<div class="pagetitle">
    <h1>Tambah Barang</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('barang-index-page') }}">Barang</a></li>
            <li class="breadcrumb-item active">Tambah Barang</li>
        </ol>
    </nav>
</div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Form Tambah Barang</h5>
            <form action="{{ route('barang-store-process') }}" method="POST">
                @csrf
                <!-- Nama Barang Input -->
        <div class="mb-3">
            <label for="Nama_Barang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" name="Nama_Barang" required>
        </div>

        <!-- Deskripsi Input -->
        <div class="mb-3">
            <label for="Deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" name="Deskripsi" rows="3" required></textarea>
        </div>

        <!-- Satuan Input -->
        <div class="mb-3">
            <label for="Satuan" class="form-label">Satuan</label>
            <input type="text" class="form-control" name="Satuan" required>
        </div>

        <!-- Harga Pokok Input -->
        <div class="mb-3">
            <label for="Harga_Pokok" class="form-label">Harga Pokok</label>
            <input type="number" class="form-control" name="Harga_Pokok" step="0.01" min="0" required>
        </div>

        <!-- Harga Jual Input -->
        <div class="mb-3">
            <label for="Harga_Jual" class="form-label">Harga Jual</label>
            <input type="number" class="form-control" name="Harga_Jual" step="0.01" min="0" required>
        </div>

        <!-- Kode Part Input -->
        <div class="mb-3">
            <label for="Kode_Part" class="form-label">Kode Part</label>
            <input type="text" class="form-control" name="Kode_Part" required>
        </div>

        <!-- Merek Input -->
        <div class="mb-3">
            <label for="Merek" class="form-label">Merek</label>
            <input type="text" class="form-control" name="Merek" required>
        </div>

            <div class="mb-3">
                <label for="ID_Kategori" class="form-label">Kategori</label>
                <select class="form-select" name="ID_Kategori" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->ID_Kategori }}">{{ $kategori->Nama_Kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="ID_Rak" class="form-label">Rak</label>
                <select class="form-select" name="ID_Rak" required>
                    <option value="">Pilih Rak</option>
                    @foreach($raks as $rak)
                        <option value="{{ $rak->ID_Rak }}">{{ $rak->Nomor_Rak }} - {{ $rak->Lokasi_Rak }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Barang</button>
        </form>
    </div>
</div>
@endsection
