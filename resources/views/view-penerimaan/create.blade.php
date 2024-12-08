@extends('Partials.dashboard-template-main')

@section('dashboard-content')
<div class="pagetitle">
    <h1>Tambah Data Penerimaan Barang</h1>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Penerimaan Barang</h5>
                    <form action="{{ route('penerimaan-store-process') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="No_Faktur" class="form-label">No Faktur</label>
                            <input type="text" class="form-control" id="No_Faktur" name="No_Faktur" required>
                        </div>

                        <div class="mb-3">
                            <label for="Tanggal_Penerimaan" class="form-label">Tanggal Penerimaan</label>
                            <input type="date" class="form-control" id="Tanggal_Penerimaan" name="Tanggal_Penerimaan" required>
                        </div>

                        <div class="mb-3">
                            <label for="ID_Supplier" class="form-label">Supplier</label>
                            <select class="form-select select2" id="ID_Supplier" name="ID_Supplier" required>
                                <option selected disabled>Pilih Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->ID_Supplier }}">{{ $supplier->Nama_Supplier }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div  class="card border shadow-none ps-3 pe-3 pb-3">
                            <div id="barang-container">
                                <div class="card-title"> Barang Yang Diterima </div>
                                    <div class="mb-3 barang-row">
                                        <div class="row">
                                            <div class="col">
                                                <label for="ID_Barang[]" class="form-label">Barang</label>
                                                <select class="form-select" name="ID_Barang[]" required>
                                                    <option selected disabled>Pilih Barang</option>
                                                    @foreach($barangs as $barang)
                                                        <option value="{{ $barang->ID_Barang }}">{{ $barang->Nama_Barang }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label for="Jumlah[]" class="form-label">Jumlah</label>
                                                <input type="number" class="form-control" name="Jumlah[]" required>
                                            </div>
                                            <div class="col pt-2">
                                                <button type="button" class="btn btn-danger remove-barang mt-4">Hapus</button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-end mt-2">
                            <button type="button" class="btn btn-secondary" id="add-barang">Tambah Barang</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
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
        newRow.querySelectorAll('input').forEach(input => input.value = '');
        container.appendChild(newRow);

        newRow.querySelector('.remove-barang').addEventListener('click', function () {
            newRow.remove();
        });
    });

    document.querySelectorAll('.remove-barang').forEach(button => {
        button.addEventListener('click', function () {
            button.closest('.barang-row').remove();
        });
    });
</script>
@endsection
