@extends('Partials.dashboard-template-main')

@section('dashboard-content')
<div class="pagetitle">
    <h1>Edit Data Penerimaan Barang</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Penerimaan</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
        <h5 class="card-title">Form Edit Penerimaan Barang</h5>

        <form action="{{ route('penerimaan-update-process', $penerimaan->ID_Penerimaan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="no_faktur" class="form-label">No Faktur</label>
                <input type="text" name="No_Faktur" id="no_faktur" class="form-control" value="{{ $penerimaan->No_Faktur }}" required>
            </div>

            <div class="mb-3">
                <label for="tanggal_penerimaan" class="form-label">Tanggal Penerimaan</label>
                <input type="date" name="Tanggal_Penerimaan" id="tanggal_penerimaan" class="form-control" value="{{ $penerimaan->Tanggal_Penerimaan }}" required>
            </div>

            <div class="mb-3">
                <label for="supplier" class="form-label">Supplier</label>
                <select name="ID_Supplier" id="supplier" class="form-select" required>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->ID_Supplier }}" {{ $supplier->ID_Supplier == $penerimaan->ID_Supplier ? 'selected' : '' }}>
                            {{ $supplier->Nama_Supplier }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <h5>Barang Yang Diterima</h5>
                <div id="barang-container">
                    @foreach($penerimaan->details as $detail)
                    <div class="row mb-2 barang-row">
                        <div class="col-md-6">
                            <select name="barang[{{ $loop->index }}][ID_Barang]" class="form-select" required>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->ID_Barang }}" {{ $barang->ID_Barang == $detail->ID_Barang ? 'selected' : '' }}>
                                        {{ $barang->Nama_Barang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="barang[{{ $loop->index }}][qty]" class="form-control" value="{{ $detail->qty }}" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm remove-barang">Hapus</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" id="add-barang" class="btn btn-primary btn-sm mt-2">Tambah Barang</button>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById('add-barang').addEventListener('click', function () {
        const container = document.getElementById('barang-container');
        const index = container.children.length;

        const row = `
            <div class="row mb-2 barang-row">
                <div class="col-md-6">
                    <select name="barang[${index}][ID_Barang]" class="form-select" required>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->ID_Barang }}">{{ $barang->Nama_Barang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="number" name="barang[${index}][qty]" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm remove-barang">Hapus</button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', row);

        // Attach event listener to the new remove button
        attachRemoveEvent();
    });

    function attachRemoveEvent() {
        document.querySelectorAll('.remove-barang').forEach(function (button) {
            button.addEventListener('click', function () {
                button.closest('.barang-row').remove();
            });
        });
    }

    attachRemoveEvent();
</script>
@endsection
