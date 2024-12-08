@extends('Partials.dashboard-template-main')
@section('dashboard-content')
<div class="row">
    <div class="col-lg-8">
        <div class="row">
            <div class="card">
                <div class="d-flex justify-content-between">
                    <div class="card-title fs-4 ms-2"> Daftar Barang</div>
                    <div class="mb-3 mt-3 col-lg-5">
                        <input type="text" id="searchBar" class="form-control" placeholder="Cari berdasarkan Nama,Harga & Kategori">
                    </div>
                </div>
                @foreach ($barang as $barangs)
                <div class="col-lg-12 item-card"
                data-id="{{ $barangs->ID_Barang }}"
                data-name="{{ $barangs->Nama_Barang }}"
                data-stock="{{ $barangs->inventaris->Jumlah_Barang_Aktual ?? 0 }}"
                data-price="{{ $barangs->Harga_Jual }}">
                    <div class="card border shadow-none">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="card-title text-dark"> {{ $barangs->Nama_Barang }} </div>
                                <div class="card-title text-success">Rp {{ number_format($barangs->Harga_Jual, 0, ',', '.') }}</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p>Stok Barang:
                                    @if(!$barangs->inventaris || $barangs->inventaris->Jumlah_Barang_Aktual == 0)
                                        <span>0</span>
                                        <span class="badge bg-danger">Habis</span>
                                    @elseif($barangs->inventaris->Jumlah_Barang_Aktual < 15)
                                        <span>{{ $barangs->inventaris->Jumlah_Barang_Aktual }}</span>
                                        <span class="badge bg-warning">Hampir Habis</span>
                                    @else
                                        <span>{{ $barangs->inventaris->Jumlah_Barang_Aktual }}</span>
                                        <span class="badge bg-success">Tersedia</span>
                                    @endif
                                </p>
                                <button
                                    class="btn btn-primary btn-beli"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalBeli"
                                    data-id="{{ $barangs->ID_Barang }}"
                                    @if(!$barangs->inventaris || $barangs->inventaris->Jumlah_Barang_Aktual == 0)
                                        disabled
                                    @endif>
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

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <form id="formPesanan" action="{{ route('store-pesanan') }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" id="inputPesanan" name="pesanan">
                    <input type="hidden" id="inputTotalPembayaran" name="totalPembayaran">
                </form>
                <div class="card-title">List Pesanan</div>
                <ul id="listPesanan" class="list-group"></ul>
                <hr>
                <p>Total Pembayaran: <span id="totalPembayaran" class="text-success">Rp 0</span></p>
                <div class="d-flex justify-content-between">
                    <button id="hapusPesanan" class="btn btn-danger">Cancel</button>
                    <button type="submit" id="submitPesanan" class="btn btn-success"> <i class="bi bi-receipt-cutoff"></i> Konfirmasi Pesanan</button>
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
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="confirmBeli" class="btn btn-primary">Konfirmasi</button>
            </div>
        </div>
    </div>
</div>



@endsection

<script>
    let pesanan = [];
    let totalPembayaran = 0;

    document.addEventListener('DOMContentLoaded', () => {
    const searchBar = document.getElementById('searchBar');
    const items = document.querySelectorAll('.item-card');

    // Event listener untuk pencarian
    searchBar.addEventListener('input', function () {
        const query = this.value.trim().toLowerCase(); // Cari dalam format lowercase
        items.forEach(item => {
            const name = item.dataset.name.toLowerCase();  // Convert data-name ke lowercase untuk pencocokan
            const stock = item.dataset.stock;
            const price = item.dataset.price;

            // Menampilkan item jika nama barang cocok dengan query pencarian
            item.style.display = name.includes(query) || stock.includes(query) || price.includes(query) ? 'block' : 'none';
            });
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const searchBar = document.getElementById('searchBar');
        const items = document.querySelectorAll('.item-card');
        const listPesanan = document.getElementById('listPesanan');
        const totalPembayaranEl = document.getElementById('totalPembayaran');
        const modalBeli = new bootstrap.Modal(document.getElementById('modalBeli'));
        const confirmBeliBtn = document.getElementById('confirmBeli');
        const barangIdInput = document.getElementById('barangId');
        const jumlahBeliInput = document.getElementById('jumlahBeli');


        document.querySelectorAll('.btn-beli').forEach(button => {
            button.addEventListener('click', function () {
                const barangId = this.getAttribute('data-id');
                barangIdInput.value = barangId;
                jumlahBeliInput.value = 1;
            });
        });

        confirmBeliBtn.addEventListener('click', () => {
            const barangId = barangIdInput.value;
            const jumlahBeli = parseInt(jumlahBeliInput.value);
            const barangEl = document.querySelector(`.item-card[data-id="${barangId}"]`);
            const barangName = barangEl.dataset.name;
            const hargaBarang = parseInt(barangEl.dataset.price);

            tambahKePesanan(barangId, barangName, hargaBarang, jumlahBeli);
            modalBeli.hide();
        });

        function tambahKePesanan(barangId, barangName, hargaBarang, jumlahBeli) {
            const existingItem = pesanan.find(item => item.id === barangId);

            if (existingItem) {
                existingItem.jumlah += jumlahBeli;
                existingItem.subTotal += hargaBarang * jumlahBeli;
            } else {
                pesanan.push({
                    id: barangId,
                    name: barangName,
                    jumlah: jumlahBeli,
                    harga: hargaBarang,
                    subTotal: hargaBarang * jumlahBeli,
                });
            }

            renderPesanan();
        }

        function renderPesanan() {
            listPesanan.innerHTML = ''; // Kosongkan daftar pesanan
            totalPembayaran = 0;

            pesanan.forEach(item => {
                const li = document.createElement('li');
                li.className = 'list-group-item';
                li.innerText = `${item.name}\n${item.jumlah} x ${item.harga.toLocaleString('id-ID')} : ${item.subTotal.toLocaleString('id-ID')}`;
                listPesanan.appendChild(li);

                totalPembayaran += item.subTotal;
            });

            totalPembayaranEl.innerText = `Rp ${totalPembayaran.toLocaleString('id-ID')}`;
        }

        const submitPesananBtn = document.getElementById('submitPesanan');

        submitPesananBtn.addEventListener('click', () => {
            if (pesanan.length === 0) {
                alert('Tidak ada pesanan untuk dikonfirmasi.');
                return;
            }

            // Data pesanan yang akan dikirim ke server
            const form = document.getElementById('formPesanan');
            const inputPesanan = document.getElementById('inputPesanan');
            const inputTotalPembayaran = document.getElementById('inputTotalPembayaran');

            // Isi data pesanan ke dalam input tersembunyi
            inputPesanan.value = JSON.stringify(pesanan);
            inputTotalPembayaran.value = totalPembayaran;

            // Kirim form ke server
            form.submit();
        });
    });
    </script>
