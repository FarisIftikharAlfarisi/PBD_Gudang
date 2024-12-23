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
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Form Pengeluaran Barang</h5>
                        <form action="{{ route('pengeluaran-store-process') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="No_Faktur" class="form-label">No Faktur</label>
                                <input type="text" class="form-control" id="No_Faktur" name="No_Faktur"
                                    value="{{ $nomor_faktur }}" required>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="Tanggal_Pengeluaran" class="form-label">Tanggal Pengeluaran</label>
                                    <input type="date" class="form-control" id="Tanggal_Pengeluaran"
                                        name="Tanggal_Pengeluaran" required>
                                </div>
                                <div class="col-6">
                                    <label for="Nama_Penerima" class="form-label">Nama Penerima</label>
                                    <input type="text" class="form-control" id="Nama_Penerima" name="Nama_Penerima"
                                        required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="Tujuan" class="form-label">Tujuan</label>
                                <input type="text" class="form-control" id="Tujuan" name="Tujuan" required>
                            </div>

                            <div class="card shadow-none border">
                                <div class="card-body">
                                    <h5 class="card-title"> <i class="bi bi-box"></i> List Barang</h5>
                                    <div id="barang-container">
                                        <div class="barang-row mb-3 d-flex align-items-center">
                                            <div class="col-lg-3 pe-2">
                                                <label for="ID_Barang" class="form-label">Barang</label>
                                                <select class="form-select" name="ID_Barang[]" required>
                                                    <option disabled selected>Pilih Barang</option>
                                                    @foreach ($barangs as $barang)
                                                        <option value="{{ $barang->ID_Barang }}">{{ $barang->Nama_Barang }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-2 pe-2">
                                                <label for="Harga" class="form-label">Harga (Rp)</label>
                                                <input type="number" class="form-control" name="Harga[]" readonly>
                                            </div>

                                            <div class="col-2 pe-2">
                                                <label for="Jumlah" class="form-label">Jumlah</label>
                                                <input type="number" class="form-control" name="Jumlah[]" min="1"
                                                    required>
                                            </div>

                                            <div class="col-2 pe-2">
                                                <label for="Diskon" class="form-label">Diskon (Rp)</label>
                                                <input type="number" class="form-control" name="Diskon[]" min="1"
                                                    required>
                                            </div>
                                            <div class="col-2 pe-2">
                                                <label for="Subtotal" class="form-label">Subtotal (Rp)</label>
                                                <input type="number" class="form-control" name="Subtotal[]" readonly>
                                            </div>                                            

                                            <div class="col-2 mt-4 pt-2">
                                                <button type="button" class="btn btn-danger remove-barang"><i
                                                        class="bi bi-trash"></i></button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="text-start">
                                        <button type="button" class="btn btn-secondary mb-3" id="add-barang"><i
                                                class="bi bi-plus"></i> Barang </button>
                                    </div>
                                    <div class="text-end mt-3">
                                        <h5>Grand Total: Rp <span id="grand_total2">0</span></h5>
                                        <input type="hidden" id="grand_total" name="grand_total" class="form-control" readonly>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Buat Pengeluaran</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Stok Barang</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangs as $barang)
                                        <tr>
                                            <td>{{ $barang->Nama_Barang }}</td>
                                            <td>{{ $barang->Jumlah_Barang_Aktual }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </div>
                    </div>
    </section>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const barangs = @json($barangs); // Ambil data barang dari backend

            // Event listener ketika barang dipilih
            document.getElementById("barang-container").addEventListener("change", function(event) {
                if (event.target.matches('select[name="ID_Barang[]"]')) {
                    const selectedBarangId = event.target.value;
                    const hargaInput = event.target.closest(".barang-row").querySelector(
                        'input[name="Harga[]"]');
                    const diskonInput = event.target.closest(".barang-row").querySelector(
                        'input[name="Diskon[]"]');
                    const jumlahInput = event.target.closest(".barang-row").querySelector(
                        'input[name="Jumlah[]"]');

                    // Cari barang yang dipilih
                    const barang = barangs.find(b => b.ID_Barang == selectedBarangId);

                    if (barang) {
                        // Set harga awal barang
                        hargaInput.value = barang.Harga_Jual;

                        // Hitung total harga awal
                        updateHargaTotal(event.target.closest(".barang-row"));
                    }
                }
            });

            // Event listener ketika Diskon atau jumlah diubah
            document.getElementById("barang-container").addEventListener("input", function(event) {
                if (event.target.matches('input[name="Diskon[]"], input[name="Jumlah[]"], select[name="ID_Barang[]"]')) {
                    updateHargaTotal(event.target.closest(".barang-row"));
                }
            });

            // Fungsi untuk menghitung harga total setelah Diskon
            function updateHargaTotal(row) {
                let grandTotal = 0;

                // Iterasi setiap baris barang
                document.querySelectorAll('.barang-row').forEach(row => {
                    const hargaInput = row.querySelector('input[name="Harga[]"]');
                    const diskonInput = row.querySelector('input[name="Diskon[]"]');
                    const jumlahInput = row.querySelector('input[name="Jumlah[]"]');
                    const subtotalInput = row.querySelector('input[name="Subtotal[]"]');

                    // Ambil nilai harga, Diskon, dan jumlah
                    let hargaAwal = parseFloat(hargaInput.value) || 0;
                    let Diskon = parseInt(diskonInput.value) || 0;
                    let jumlah = parseInt(jumlahInput.value) || 1;

                    // Hitung harga setelah Diskon dan subtotal
                    const hargaSetelahDiskon = hargaAwal - Diskon;
                    const subtotal = hargaSetelahDiskon * jumlah;

                    // Perbarui nilai subtotal pada input
                    subtotalInput.value = subtotal;

                    // Tambahkan subtotal ke Grand Total
                    grandTotal += subtotal;
                });

                // Perbarui tampilan Grand Total
                document.getElementById('grand_total2').textContent = grandTotal.toLocaleString('id-ID');
                // Perbarui nilai Grand Total di input
                document.getElementById('grand_total').value = grandTotal;

            }
        });

        function updateRemoveButtonState() {
            const barangRows = document.querySelectorAll('.barang-row');
            const removeButtons = document.querySelectorAll('.remove-barang');

            // Nonaktifkan tombol hapus jika hanya ada satu barang-row
            if (barangRows.length === 1) {
                removeButtons.forEach(button => button.disabled = true);
            } else {
                removeButtons.forEach(button => button.disabled = false);
            }
        }

        document.getElementById('add-barang').addEventListener('click', function() {
            const container = document.getElementById('barang-container');
            const newRow = document.querySelector('.barang-row').cloneNode(true);

            // Bersihkan nilai input dalam baris baru
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            newRow.querySelector('select').selectedIndex = 0;

            // Tambahkan event listener untuk tombol "Hapus" di baris baru
            newRow.querySelector('.remove-barang').addEventListener('click', function() {
                newRow.remove();
                updateRemoveButtonState();
                updateHargaTotal(event.target.closest(".barang-row"));
            });

            container.appendChild(newRow);
            updateRemoveButtonState(); // Perbarui status tombol hapus
            updateHargaTotal(event.target.closest(".barang-row"));
        });

        // Menambahkan event listener ke setiap tombol "Hapus" yang sudah ada saat halaman dimuat
        document.querySelectorAll('.remove-barang').forEach(button => {
            button.addEventListener('click', function() {
                button.closest('.barang-row').remove();
                updateRemoveButtonState();
                updateHargaTotal(event.target.closest(".barang-row"));
            });
        });

        // Perbarui status tombol hapus saat halaman dimuat
        updateRemoveButtonState();
        updateHargaTotal(event.target.closest(".barang-row"));
    </script>
@endsection
