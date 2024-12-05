@extends('Partials.dashboard-template-main')

@section('dashboard-content')
<div class="pagetitle">
    <h1>Tambah Supplier</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('supplier-index-page') }}">Supplier</a></li>
            <li class="breadcrumb-item active">Tambah Supplier</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-8">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Tambah Supplier</h5>

                    <!-- Supplier Form -->
                    <form action="{{ route('suppliers.store') }}" method="POST">
                        @csrf

                        <!-- Nama Supplier -->
                        <div class="mb-3">
                            <label for="Nama_Supplier" class="form-label">Nama Supplier</label>
                            <input type="text" class="form-control @error('Nama_Supplier') is-invalid @enderror" id="Nama_Supplier" name="Nama_Supplier" value="{{ old('Nama_Supplier') }}" required>
                            @error('Nama_Supplier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label for="Alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('Alamat') is-invalid @enderror" id="Alamat" name="Alamat" rows="3" required>{{ old('Alamat') }}</textarea>
                            @error('Alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="mb-3">
                            <label for="Nomor_Telepon" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control @error('Nomor_Telepon') is-invalid @enderror" id="Nomor_Telepon" name="Nomor_Telepon" value="{{ old('Nomor_Telepon') }}" required>
                            @error('Nomor_Telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="Email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('Email') is-invalid @enderror" id="Email" name="Email" value="{{ old('Email') }}" required>
                            @error('Email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Spesialisasi -->
                        <div class="mb-3">
                            <label for="Spesialisasi" class="form-label">Spesialisasi</label>
                            <input type="text" class="form-control @error('Spesialisasi') is-invalid @enderror" id="Spesialisasi" name="Spesialisasi" value="{{ old('Spesialisasi') }}" required>
                            @error('Spesialisasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('supplier-index-page') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form><!-- End Supplier Form -->

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
