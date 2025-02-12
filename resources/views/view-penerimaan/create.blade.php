@extends('Partials.dashboard-template-main')

@section('dashboard-content')
<div class="pagetitle">
    <h1>Tambah Data Penerimaan Barang</h1>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Penerimaan Barang</h5>
                    <form action="{{ route('penerimaan-store-process') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="No_Faktur" class="form-label">No. Faktur</label>
                                <input type="text" class="form-control" id="No_Faktur" name="No_Faktur" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="Tanggal_Penerimaan" class="form-label">Tanggal Penerimaan</label>
                                <input type="date" class="form-control" id="Tanggal_Penerimaan" name="Tanggal_Penerimaan" required>
                            </div>
                            <div class="col-6">
                                <label for="ID_Supplier" class="form-label">Supplier</label>
                                <select class="form-select select2" id="ID_Supplier" name="ID_Supplier" required>
                                    <option selected disabled>Pilih Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->ID_Supplier }}">{{ $supplier->Nama_Supplier }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div  class="card border shadow-none ps-3 pe-3 pb-3">
                            <div class="card-title"> Barang Yang Diterima </div>
                            <div id="barang-container">
                                    <div class="mb-3 barang-row">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label for="ID_Barang[]" class="form-label">Barang</label>
                                                <select class="form-select" name="ID_Barang[]" required>
                                                    <option selected disabled>Pilih Barang</option>
                                                    @foreach($barangs as $barang)
                                                        <option value="{{ $barang->ID_Barang }}" data-satuan="{{ $barang->Satuan }}" > {{ $barang->Kode_Part }} | {{ $barang->Nama_Barang }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-2">
                                                <label for="Jumlah[]" class="form-label">Jumlah</label>
                                                <input type="number" class="form-control" name="Jumlah[]" required>
                                            </div>
                                            <div class="col-3">
                                                <label for="Harga_Baru" class="form-label">Harga Baru (Rp)</label>
                                                <input type="number" class="form-control" name="Harga_Baru[]">
                                            </div>
                                            <div class="col pt-2">
                                                <button type="button" class="btn btn-danger remove-barang mt-4"><i class="bi bi-trash"></i></button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                            </div>
                            <div class="text-start">
                                <button type="button" class="btn btn-secondary" id="add-barang"><i class="bi bi-plus"></i> Barang </button>
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-end mt-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('barang-container');
    const addButton = document.getElementById('add-barang');

    function updateRemoveButtonState() {
        const rows = container.querySelectorAll('.barang-row');
        rows.forEach((row, index) => {
            const removeButton = row.querySelector('.remove-barang');
            if (rows.length === 1) {
                // Disable tombol hapus jika hanya ada satu row
                removeButton.disabled = true;
            } else {
                // Enable tombol hapus jika lebih dari satu row
                removeButton.disabled = false;
            }
        });
    }

    addButton.addEventListener('click', function () {
        const newRow = document.querySelector('.barang-row').cloneNode(true);
        newRow.querySelectorAll('input').forEach(input => input.value = '');
        newRow.querySelector('.remove-barang').addEventListener('click', function () {
            newRow.remove();
            updateRemoveButtonState(); // Update tombol hapus setelah row dihapus
        });
        container.appendChild(newRow);
        updateRemoveButtonState(); // Update tombol hapus setelah row baru ditambahkan
    });

    document.querySelectorAll('.remove-barang').forEach(button => {
        button.addEventListener('click', function () {
            button.closest('.barang-row').remove();
            updateRemoveButtonState(); // Update tombol hapus setelah row dihapus
        });
    });

    // Set initial state of remove buttons
    updateRemoveButtonState();
});

</script>
@endsection
