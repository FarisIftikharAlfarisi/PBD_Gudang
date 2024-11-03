@extends('Partials.dashboard-template-main')

@section('dashboard-content')
<div class="pagetitle">
    <h1>Pengeluaran Barang</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item">Pengeluaran</li>
        <li class="breadcrumb-item active">Pengeluaran Baru</li>
      </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Pengeluaran Barang</h5>
                    <form action="{{ route('pengeluaran-store-process') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="No_Faktur" class="form-label">No Faktur</label>
                            <input type="text" class="form-control" id="No_Faktur" name="No_Faktur" required>
                        </div>

                        <div class="mb-3">
                            <label for="Tanggal_Pengeluaran" class="form-label">Tanggal Pengeluaran</label>
                            <input type="date" class="form-control" id="Tanggal_Pengeluaran" name="Tanggal_Pengeluaran" required>
                        </div>

                        <div id="barang-container">
                            <div class="barang-row mb-3 d-flex align-items-center">
                                <div class="col-6 pe-2">
                                    <label for="ID_Barang" class="form-label">Barang</label>
                                    <select class="form-select" name="ID_Barang[]" required>
                                        <option disabled selected>Pilih Barang</option>
                                        @foreach($barangs as $barang)
                                            <option value="{{ $barang->ID_Barang }}">{{ $barang->Nama_Barang }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-4 pe-2">
                                    <label for="Jumlah" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" name="Jumlah[]" min="1" required>
                                </div>

                                <div class="col-2 mt-4 pt-2">
                                    <button type="button" class="btn btn-danger remove-barang">Hapus</button>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary mb-3" id="add-barang">Tambah Barang</button>


                        <div class="mb-3">
                            <label for="Nama_Penerima" class="form-label">Nama Penerima</label>
                            <input type="text" class="form-control" id="Nama_Penerima" name="Nama_Penerima" required>
                        </div>

                        <div class="mb-3">
                            <label for="Tujuan" class="form-label">Tujuan</label>
                            <input type="text" class="form-control" id="Tujuan" name="Tujuan" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    document.getElementById('add-barang').addEventListener('click', function () {
        const container = document.getElementById('barang-container');
        const newRow = document.querySelector('.barang-row').cloneNode(true);

        // Bersihkan nilai input dalam baris baru
        newRow.querySelectorAll('input').forEach(input => input.value = '');
        newRow.querySelector('select').selectedIndex = 0;

        // Tambahkan event listener untuk tombol "Hapus" di baris baru
        newRow.querySelector('.remove-barang').addEventListener('click', function () {
            newRow.remove();
        });

        container.appendChild(newRow);
    });

    // Menambahkan event listener ke setiap tombol "Hapus" yang sudah ada saat halaman dimuat
    document.querySelectorAll('.remove-barang').forEach(button => {
        button.addEventListener('click', function () {
            button.closest('.barang-row').remove();
        });
    });
</script>
@endsection
