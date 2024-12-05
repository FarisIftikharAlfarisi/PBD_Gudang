@extends('Partials.dashboard-template-main')

@section('dashboard-content')
<div class="pagetitle">
    <h1>Tambah Karyawan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('karyawan-index-page') }}">Karyawan</a></li>
            <li class="breadcrumb-item active">Tambah Karyawan</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-8">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Tambah Karyawan</h5>

                    <!-- Form Tambah Karyawan -->
                    <form method="POST" action="{{ route('karyawan-store-process') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="Nomor_karyawan" class="col-sm-3 col-form-label">Nomor Karyawan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('Nomor_karyawan') is-invalid @enderror" id="Nomor_karyawan" name="Nomor_karyawan" value="{{ old('Nomor_karyawan') }}" required>
                                @error('Nomor_karyawan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Nama_Karyawan" class="col-sm-3 col-form-label">Nama Karyawan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('Nama_Karyawan') is-invalid @enderror" id="Nama_Karyawan" name="Nama_Karyawan" value="{{ old('Nama_Karyawan') }}" required>
                                @error('Nama_Karyawan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Alamat" class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                                <textarea class="form-control @error('Alamat') is-invalid @enderror" id="Alamat" name="Alamat" rows="3" required>{{ old('Alamat') }}</textarea>
                                @error('Alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Nomor_Telepon" class="col-sm-3 col-form-label">Nomor Telepon</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('Nomor_Telepon') is-invalid @enderror" id="Nomor_Telepon" name="Nomor_Telepon" value="{{ old('Nomor_Telepon') }}" required>
                                @error('Nomor_Telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Jabatan" class="col-sm-3 col-form-label">Jabatan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('Jabatan') is-invalid @enderror" id="Jabatan" name="Jabatan" value="{{ old('Jabatan') }}" required>
                                @error('Jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('karyawan-index-page') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form><!-- End Form Tambah Karyawan -->

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
