@extends('Partials.dashboard-template-main')
@section('dashboard-content')
<div class="pagetitle">
    <h1>Tambah Rak</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item">Penyimpanan</li>
        <li class="breadcrumb-item"><a href="{{ route('rak-index-page') }}">Rak</a></li>
        <li class="breadcrumb-item active">Tambah Rak</li>
      </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Form Tambah Rak</h5>
        <form action="{{ route('rak-store-process') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="Nomor_Rak" class="form-label">Nomor Rak</label>
                <input type="text" name="Nomor_Rak" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="Lokasi_Rak" class="form-label">Lokasi Rak</label>
                <input type="text" name="Lokasi_Rak" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="Kapasitas_Rak" class="form-label">Kapasitas Rak</label>
                <input type="number" name="Kapasitas_Rak" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="Status_Rak" class="form-label">Status Rak</label>
                <select name="Status_Rak" class="form-select" required>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="ID_Gudang" class="form-label">Gudang</label>
                <select name="ID_Gudang" class="form-select" required>
                    @foreach($gudangs as $gudang)
                        <option value="{{ $gudang->ID_Gudang }}">{{ $gudang->Nama_Gudang }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Rak</button>
            <a href="{{ route('rak-index-page') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
