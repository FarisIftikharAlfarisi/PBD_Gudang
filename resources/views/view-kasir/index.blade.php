@extends('Partials.dashboard-template-main')
@section('dashboard-content')
    <div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <div class="card-title fs-4 ms-2"> Daftar Barang</div>
                        <div class="mb-3 mt-3 col-lg-5">
                            <input type="text" id="searchBar" class="form-control"
                                placeholder="Cari berdasarkan Nama,Harga & Kategori">
                        </div>
                    </div>
                    @foreach ($barang as $barangs)
                        <div class="col-lg-12 item-card" data-id="{{ $barangs->ID_Barang }}"
                            data-name="{{ $barangs->Nama_Barang }}" data-kodepart="{{ $barangs->Kode_Part }}"
                            data-stock="{{ $barangs->inventaris->Jumlah_Barang_Aktual ?? 0 }}"
                            data-price="{{ $barangs->Harga_Jual }}">
                            <div class="card border shadow-none">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="card-title text-dark"> <strong>{{ $barangs->Kode_Part }}</strong>
                                            &nbsp;&nbsp; | {{ $barangs->Nama_Barang }} </div>
                                        <div class="card-title text-success">Rp
                                            {{ number_format($barangs->Harga_Jual, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p>
                                            @if (!$barangs->inventaris || $barangs->inventaris->Jumlah_Barang_Aktual == 0)
                                                <span class="badge bg-danger">Habis</span>
                                                <span>0</span>
                                            @elseif($barangs->inventaris->Jumlah_Barang_Aktual < 18)
                                                <span class="badge bg-warning">Hampir Habis</span>
                                                <span>{{ $barangs->inventaris->Jumlah_Barang_Aktual }}</span>
                                            @else
                                                <span class="badge bg-success">Tersedia</span>
                                                <span>{{ $barangs->inventaris->Jumlah_Barang_Aktual }}</span>
                                            @endif
                                        </p>
                                        <button class="btn btn-primary btn-beli" id="btnTambahBarang" data-bs-toggle="modal"
                                            data-bs-target="#modalBeli" data-id="{{ $barangs->ID_Barang }}"
                                            data-stok="{{ $barangs->inventaris->Jumlah_Barang_Aktual ?? 0 }}"
                                            @if (!$barangs->inventaris || $barangs->inventaris->Jumlah_Barang_Aktual == 0) disabled @endif>
                                            <i class="bi bi-cart-plus"></i> Beli
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-title"> Jenis Pelanggan </div>
                    <div class="form-check">
                        <input type="checkbox" name="PelangganTetap" id="PelangganTetap" class="form-check-input">Pelanggan
                        Tetap
                        <div id="showLoyalCustSelect"></div>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="PelangganBaru" id="PelangganBaru" class="form-check-input">Pelanggan
                        Baru
                        <div id="showFormNewCustomer"></div>
                    </div>
                    <form id="formPesanan" action="{{ route('store-pesanan') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" id="inputPesanan" name="pesanan">
                        <input type="hidden" id="inputTotalPembayaran" name="totalPembayaran">
                        <input type="hidden" id="inputCustomer" name="customer">
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-title">List Pesanan</div>
                    <ul id="listPesanan" class="list-group"></ul>
                    <hr>
                    <p>Total Pembayaran: <span id="totalPembayaran" class="text-success">Rp 0</span></p>
                    <div class="text-end">
                        <button type="submit" id="submitPesanan" class="btn btn-success "> <i
                                class="bi bi-receipt-cutoff"></i> Konfirmasi Pesanan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalBeli" tabindex="-1" aria-labelledby="modalBeliLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBeliLabel">Konfirmasi Pembelian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formBeli">
                        <input type="hidden" id="barangId">
                        <div class="mb-3">
                            <label for="jumlahBeli" class="form-label">Jumlah yang akan dibeli</label>
                            <input type="number" id="jumlahBeli" class="form-control" min="1" value="1">
                            <span class="text-danger"><span id="errorStok"></span></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="clearBeli" class="btn btn-secondary"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="confirmBeli" class="btn btn-primary">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('customJS/keranjang.js') }}"></script>
    <script src="{{ asset('customJS/customer.js') }}"></script>

    <script>
        // buat validasi inputan
        // validasi input jumlah barang
        document.addEventListener("DOMContentLoaded", function() {
            // Variabel global untuk stok barang yang dipilih
            let currentStock = 0;

            // Menangkap semua tombol "Beli" dan menambahkan event listener
            const btnBeli = document.querySelectorAll(".btn-beli");

            btnBeli.forEach(button => {
                button.addEventListener("click", function() {
                    // Ambil stok dari data-stok tombol yang diklik
                    currentStock = parseInt(this.getAttribute("data-stok"));

                    // Reset form modal
                    document.getElementById("jumlahBeli").value = 1; // Reset input ke 1
                    document.getElementById("confirmBeli").disabled =
                    false;
                    document.getElementById("jumlahBeli").classList.remove(
                    "is-invalid");
                });
            });

            // Input jumlah beli
            const inputJumlahBeli = document.getElementById("jumlahBeli");
            const confirmButton = document.getElementById("confirmBeli");
            const InvalidStok = document.getElementById("errorStok");
            inputJumlahBeli.addEventListener("input", function() {
                const inputValue = parseInt(this.value) || 0;

                if (inputValue > currentStock) {
                    this.classList.add("is-invalid");
                    InvalidStok.textContent = "Stok barang tidak mencukupi!";
                    confirmButton.disabled = true;
                } else if (inputValue < 1) {
                    this.classList.add("is-invalid");
                    InvalidStok.textContent = "Jumlah harus diisi!";
                    confirmButton.disabled = true;
                } else {
                    this.classList.remove("is-invalid");
                    InvalidStok.textContent = "";
                    confirmButton.disabled = false;
                }
            });
        });
    </script>

    <script>
        // 1. Ketika checkbox pelanggan diklik
        const pelangganTetapCheckbox = document.getElementById("pelangganTetap");
        const pelangganBaruCheckbox = document.getElementById("pelangganBaru");
        const pelangganContainer = document.createElement("div");
        const pelangganBaruForm = document.createElement("div");
        const pelangganTetapForm = document.createElement("select");

        const DataPelanggan = []; // Array untuk menyimpan data pelanggan baru
        const pesanan = []; // Array untuk menyimpan pesanan barang

        // 1. Pelanggan Tetap
        pelangganTetapCheckbox.addEventListener("change", function() {
            pelangganContainer.innerHTML = "";
            if (this.checked) {
                pelangganTetapForm.innerHTML = "<option value=''>Pilih Pelanggan Tetap</option>";
                fetch('URL_TO_FETCH_CUSTOMERS')
                    .then((res) => res.json())
                    .then((data) => {
                        data.forEach((pelanggan) => {
                            const option = document.createElement("option");
                            option.value = pelanggan.id;
                            option.textContent = pelanggan.nama;
                            pelangganTetapForm.appendChild(option);
                        });
                    });
                pelangganContainer.appendChild(pelangganTetapForm);
            }
        });

        // 2. Pelanggan Baru
        pelangganBaruCheckbox.addEventListener("change", function() {
            pelangganContainer.innerHTML = "";
            if (this.checked) {
                pelangganBaruForm.innerHTML = `
            <div style='border: 1px solid #ccc; padding: 10px;'>
                <label>Nama: <input type='text' id='namaPelangganBaru' required ></label>
                <label>Nomor Telepon: <input type='text' id='noTelpPelangganBaru' required ></label>
            </div>
        `;
                pelangganContainer.appendChild(pelangganBaruForm);
            }
        });

        // 3. Form Diskon untuk Item
        const listPesanan = document.querySelectorAll(".item"); // Gantilah sesuai class dari item
        listPesanan.forEach((item) => {
            const discountInput = document.createElement("input");
            discountInput.type = "number";
            discountInput.placeholder = "Diskon (%)";
            discountInput.addEventListener("input", function() {
                const hargaAwal = parseInt(item.getAttribute("data-harga"));
                const diskon = parseFloat(this.value) || 0;
                const hargaAkhir = hargaAwal - (hargaAwal * diskon) / 100;
                item.querySelector(".harga").textContent = `Rp ${hargaAkhir}`;
                updatePesanan(item.dataset.id, hargaAkhir);
            });
            item.appendChild(discountInput);
        });

        function updatePesanan(id, hargaBaru) {
            const index = pesanan.findIndex((p) => p.id === id);
            if (index !== -1) {
                pesanan[index].harga = hargaBaru;
            } else {
                pesanan.push({
                    id,
                    harga: hargaBaru
                });
            }
        }

        // 4. Pengiriman Data
        const konfirmasiButton = document.getElementById("konfirmasiPesanan");
        konfirmasiButton.addEventListener("click", () => {
            const inputPesanan = document.getElementById("inputPesanan");
            const inputTotalPembayaran = document.getElementById("inputTotalPembayaran");
            const inputDataCustomer = document.getElementById("inputDataCustomer");

            let totalPembayaran = pesanan.reduce((sum, p) => sum + p.harga, 0);
            inputPesanan.value = JSON.stringify(pesanan);
            inputTotalPembayaran.value = totalPembayaran;

            if (pelangganTetapCheckbox.checked) {
                inputDataCustomer.value = JSON.stringify({
                    ID: pelangganTetapForm.value,
                    Jenis_Pelanggan: "pelanggan_tetap",
                });
            } else if (pelangganBaruCheckbox.checked) {
                const nama = document.getElementById("namaPelangganBaru").value;
                const noTelp = document.getElementById("noTelpPelangganBaru").value;
                DataPelanggan.push({
                    nama,
                    noTelp
                });
                inputDataCustomer.value = JSON.stringify({
                    Nama: nama,
                    Nomor_Telepon: noTelp,
                    Jenis_Pelanggan: "pelanggan_baru",
                });
            }
        });
    </script>
@endsection
