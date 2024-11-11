@extends('Partials.dashboard-template-main')

@section('dashboard-content')
<div class="pagetitle">
    <h1>Tambah Kategori</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('kategori-index-page') }}">Kategori</a></li>
            <li class="breadcrumb-item active">Tambah Kategori</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-8">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Tambah Kategori</h5>
                    <!-- Form Tambah Kategori -->
                    <form action="{{ route('kategori-store-process') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="Nama_Kategori" class="form-label">Nama Kategori</label>
                            <input type="text" name="Nama_Kategori" class="form-control @error('Nama_Kategori') is-invalid @enderror" id="Nama_Kategori" required>
                            @error('Nama_Kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Tambah Kategori</button>
                        <a href="{{ route('kategori-index-page') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                    <!-- End Form Tambah Kategori -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection