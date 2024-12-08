@extends('Partials.dashboard-template-main')
@section('dashboard-content')
<div class="pagetitle">
    <h1>Tambah Gudang</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('gudang-index-page') }}">Gudang</a></li>
            <li class="breadcrumb-item active">Tambah Gudang</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Tambah Gudang</h5>
                    
                    <!-- Form Tambah Gudang -->
                    <form action="{{ route('gudang-store-process') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="Nama_Gudang" class="form-label">Nama Gudang</label>
                            <input type="text" name="Nama_Gudang" class="form-control @error('Nama_Gudang') is-invalid @enderror" id="Nama_Gudang" required>
                            @error('Nama_Gudang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="Lokasi" class="form-label">Lokasi</label>
                            <input type="text" name="Lokasi" class="form-control @error('Lokasi') is-invalid @enderror" id="Lokasi" required>
                            @error('Lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Tambah Gudang</button>
                        <a href="{{ route('gudang-index-page') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                    <!-- End Form Tambah Gudang -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
