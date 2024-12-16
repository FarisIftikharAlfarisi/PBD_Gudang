@extends('Partials.dashboard-template-main')
@section('dashboard-content')
    <div class="row">
        <div class="col-lg-7">
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
                            data-partcode="{{ $barangs->Kode_Part }}"
                            data-name="{{ $barangs->Nama_Barang }}"
                            data-stock="{{ $barangs->inventaris->Jumlah_Barang_Aktual ?? 0 }}"
                            data-price="{{ $barangs->Harga_Jual }}">
                            <div class="card border shadow-none">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="card-title text-dark"> <strong> {{ $barangs->Kode_Part }} </strong> | {{ $barangs->Nama_Barang }} </div>
                                        <br>
                                        <div class="card-title text-success">Rp
                                            {{ number_format($barangs->Harga_Jual, 0, ',', '.') }}</div>
                                    </div>
                                    <div>
                                        <p> {{ $barangs->kategori->Nama_Kategori ?? '<span class="badge bg-secondary">Belum Dikategorikan</span>' }} &nbsp <i class="bi bi-tag text-primary"></i></p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p>Stok Barang:
                                            @if (!$barangs->inventaris || $barangs->inventaris->Jumlah_Barang_Aktual == 0)
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
                                        <button class="btn btn-primary btn-beli" data-bs-toggle="modal"
                                            data-bs-target="#modalBeli" data-id="{{ $barangs->ID_Barang }}"
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

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <form id="formPesanan" action="{{ route('store-pesanan') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" id="inputPesanan" name="pesanan">
                        <input type="hidden" id="inputDataPembeli" name="data_pembeli">
                        <input type="hidden" id="inputTotalPembayaran" name="totalPembayaran">
                    </form>
                    <div class="card-title">List Pesanan</div>
                    <ul id="listPesanan" class="list-group"></ul>
                    <hr>
                    <p>Total Pembayaran: <span id="totalPembayaran" class="text-success">Rp 0</span></p>
                    <div class="d-flex justify-content-between">
                        <button id="hapusPesanan" class="btn btn-danger">Cancel</button>
                        <button type="submit" id="submitPesanan" class="btn btn-success"> <i
                                class="bi bi-receipt-cutoff"></i> Konfirmasi Pesanan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Jumlah Barang Modals --}}
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

    {{-- modal untuk konfirmasi pesanan --}}
    <div class="modal fade" id="modalConfirmBeli" tabindex="-1" aria-labelledby="modalConfirmBeliLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirmBeliLabel">Konfirmasi Pembelian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formBeli">
                        <input type="hidden" id="barangId">
                        <div class="mb-3">
                            <div id="listPesananModal"></div>
                        </div>
                        <hr>
                        <div class="d-flex justifty-content-between">
                            <div><strong>Total Bayar</strong></div>
                            <div id="totalPembayaranAll" class="mt-3">
                            </div>
                        </div>
                        <hr>
                        {{-- Form Pelanggan Tetap --}}
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="isPelangganTetap">
                            <label class="form-check-label" for="isPelangganTetap">
                                Pelanggan Tetap (Berikan Diskon)
                            </label>
                        </div>
                        <div id="formDiskon" class="mt-3" style="display: none;">
                            <select class="form-select" id="idPelangganTetap" name="namePelangganTetap">
                                <option value="NULL">Nama Pelanggan</option>
                                @foreach ($loyal_customer as $customer)
                                    <option value="{{ $customer->ID_Pelanggan }}">{{ $customer->Nama_Pelanggan }}</option>
                                @endforeach
                            </select>
                            <div id="diskonOptions">
                                <p>Atur diskon untuk setiap barang (centang untuk memberikan diskon):</p>
                            </div>
                        </div>

                        {{-- Form Pelanggan Baru --}}
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="isPelangganBaru">
                            <label class="form-check-label" for="isPelangganBaru">
                                Tambahkan sebagai Pelanggan Baru
                            </label>
                        </div>
                        <div id="formPelangganBaru" class="mt-3" style="display: none;">
                            <div class="mb-3">
                                <label for="namaPelanggan" class="form-label">Nama Pelanggan</label>
                                <input type="text" id="namaPelanggan" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="nomorTelepon" class="form-label">Nomor Telepon</label>
                                <input type="text" id="nomorTelepon" class="form-control">
                            </div>
                        </div>
                        {{-- Form Pelanggan Biasa --}}
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="isPelangganBiasa">
                            <label class="form-check-label" for="isPelangganBiasa">
                                Pelanggan Biasa (Tanpa Diskon)
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="confirmBeliModalButton" class="btn btn-primary">Konfirmasi</button>
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
        searchBar.addEventListener('input', function() {
            const query = this.value.trim().toLowerCase(); // Cari dalam format lowercase
            items.forEach(item => {
                const name = item.dataset.name
                    .toLowerCase(); // Convert data-name ke lowercase untuk pencocokan
                const stock = item.dataset.stock;
                const price = item.dataset.price;
                const part_code = item.dataset.partcode.toLowerCase();

                // Menampilkan item jika nama barang cocok dengan query pencarian
                item.style.display = name.includes(query) || stock.includes(query) || price.includes(query) || part_code.includes(query) ? 'block' : 'none';
            });
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const listPesanan = document.getElementById('listPesanan');
        const totalPembayaranEl = document.getElementById('totalPembayaran');
        const modalBeli = new bootstrap.Modal(document.getElementById('modalBeli'));
        const confirmBeliBtn = document.getElementById('confirmBeli');
        const barangIdInput = document.getElementById('barangId');
        const jumlahBeliInput = document.getElementById('jumlahBeli');


        document.querySelectorAll('.btn-beli').forEach(button => {
            button.addEventListener('click', function() {
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
                    ID_Barang: barangId,
                    Nama_Barang: barangName,
                    Jumlah_Beli: jumlahBeli,
                    Harga_Barang: hargaBarang,
                    Subtotal: hargaBarang * jumlahBeli,
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

                // Access the correct properties and ensure they exist
                const itemName = item.Nama_Barang || 'Nama barang tidak tersedia';
                const itemHarga = item.Harga_Barang ? item.Harga_Barang.toLocaleString('id-ID') :
                    'Harga tidak tersedia';
                const itemSubTotal = item.Subtotal ? item.Subtotal.toLocaleString('id-ID') :
                    'Subtotal tidak tersedia';

                li.innerText = `${itemName}\n${item.Jumlah_Beli} x ${itemHarga} : ${itemSubTotal}`;
                listPesanan.appendChild(li);

                totalPembayaran += item.Subtotal || 0;
            });

            totalPembayaranEl.innerText = `Rp ${totalPembayaran.toLocaleString('id-ID')}`;
        }

        const submitPesananBtn = document.getElementById('submitPesanan');

        // submitPesananBtn.addEventListener('click', () => {
        //     if (pesanan.length === 0) {
        //         alert('Tidak ada pesanan untuk dikonfirmasi.');
        //         return;
        //     }

        //     // Data pesanan yang akan dikirim ke server
        //     const form = document.getElementById('formPesanan');
        //     const inputPesanan = document.getElementById('inputPesanan');
        //     const inputTotalPembayaran = document.getElementById('inputTotalPembayaran');

        //     // Isi data pesanan ke dalam input tersembunyi
        //     inputPesanan.value = JSON.stringify(pesanan);
        //     inputTotalPembayaran.value = totalPembayaran;

        //     // Kirim form ke server
        //     form.submit();
        //     });
    });

    //Menampilkan Seluruh Barang Yang akan di beli pada modal
    function tampilkanPesanan() {
        listPesananModal.innerHTML = '';
        diskonOptions.innerHTML = '';

        if (pesanan.length === 0) {
            listPesananModal.innerHTML = '<p>Tidak ada pesanan saat ini.</p>';
            return;
        }

        const table = document.createElement('table');
        table.className = 'table table-striped';
        const thead = document.createElement('thead');
        thead.innerHTML = `
        <tr>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Diskon</th>
            <th>Subtotal</th>
        </tr>`;
        table.appendChild(thead);

        const tbody = document.createElement('tbody');
        pesanan.forEach((item, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
            <td>${item.Nama_Barang}</td>
            <td>${item.Jumlah_Beli}</td>
            <td>${item.Harga_Barang.toLocaleString('id-ID')}</td>
            <td id="diskonValue-${index}">${item.diskon || 0}</td>
            <td id="subTotal-${index}">${item.Subtotal.toLocaleString('id-ID')}</td>`;
            tbody.appendChild(row);

            const diskonOption = document.createElement('div');
            diskonOption.className = 'form-check';
            diskonOption.innerHTML = `
            <input type="checkbox" class="form-check-input" id="applyDiskon-${index}" data-index="${index}">
            <label class="form-check-label" for="applyDiskon-${index}">Berikan diskon untuk <strong>${item.Nama_Barang}</strong></label>
            <div id="diskonForm-${index}" style="display: none; margin-top: 5px;">
                <label for="diskonInput-${index}" class="form-label">Diskon (Rp)</label>
                <input type="number" id="diskonInput-${index}" class="form-control" min="0" value="${item.diskon || 0}">
            </div>`;
            diskonOptions.appendChild(diskonOption);

            document.getElementById(`applyDiskon-${index}`)?.addEventListener('change', function() {
                const isChecked = this.checked;
                const diskonForm = document.getElementById(`diskonForm-${index}`);
                document.getElementById(`diskonInput-${index}`).value = item.diskon || 0;
                diskonForm.style.display = isChecked ? 'block' : 'none';
                if (!isChecked) updateDiskon(index, 0);
            });

            document.getElementById(`diskonInput-${index}`)?.addEventListener('input', function() {
                const value = parseInt(this.value) || 0;
                updateDiskon(index, value);
            });
        });

        table.appendChild(tbody);
        listPesananModal.appendChild(table);
    }

    function updateDiskon(index, diskon) {
        const item = pesanan[index];
        item.diskon = diskon;
        item.Subtotal = (item.Harga_Barang - diskon) * item.Jumlah_Beli;
        document.getElementById(`diskonValue-${index}`).textContent = diskon;
        document.getElementById(`subTotal-${index}`).textContent = item.Subtotal.toLocaleString('id-ID');
        hitungTotalPesanan();
    }

    function hitungTotalPesanan() {
        totalPembayaran = pesanan.reduce((total, item) => total + item.Subtotal, 0);
        document.getElementById('totalPembayaranAll').textContent = `Rp ${totalPembayaran.toLocaleString('id-ID')}`;
    }

    //modal confirm handling
    document.addEventListener('DOMContentLoaded', () => {
        // Modal untuk konfirmasi pesanan
        const modalConfirmBeli = new bootstrap.Modal(document.getElementById('modalConfirmBeli'));
        const submitPesananBtn = document.getElementById('submitPesanan');

        // Event listener untuk membuka modal
        submitPesananBtn.addEventListener('click', () => {
            if (pesanan.length === 0) {
                alert('Tidak ada pesanan untuk dikonfirmasi.');
                return;
            }
            // Buka modal konfirmasi pesanan
            console.log(pesanan);
            tampilkanPesanan()
            modalConfirmBeli.show();
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const isPelangganTetap = document.getElementById('isPelangganTetap');
        const formDiskon = document.getElementById('formDiskon');
        const isPelangganBaru = document.getElementById('isPelangganBaru');
        const formPelangganBaru = document.getElementById('formPelangganBaru');
        const diskonOptions = document.getElementById('diskonOptions');

        // Tampilkan/hilangkan form diskon untuk pelanggan tetap
        isPelangganTetap.addEventListener('change', () => {
            formDiskon.style.display = isPelangganTetap.checked ? 'block' : 'none';
            diskonOptions.style.display = isPelangganTetap.checked ? 'block' : 'none';
        });

        // Tampilkan/hilangkan form pelanggan baru
        isPelangganBaru.addEventListener('change', () => {
            formPelangganBaru.style.display = isPelangganBaru.checked ? 'block' : 'none';
        });

        const confirmBeliBtn = document.getElementById('confirmBeli');
        confirmBeliBtn.addEventListener('click', () => {
            const barangId = document.getElementById('barangId').value;
            const jumlahBeli = parseInt(document.getElementById('jumlahBeli').value);
            const barangEl = document.querySelector(`.item-card[data-id="${barangId}"]`);
            const barangName = barangEl.dataset.name;
            const hargaBarang = parseInt(barangEl.dataset.price);

            const pelangganTetap = isPelangganTetap.checked;
            const diskon = pelangganTetap ? parseInt(document.getElementById('diskon').value) : 0;
            const pelangganBaru = isPelangganBaru.checked;
            const namaPelanggan = pelangganBaru ? document.getElementById('namaPelanggan').value : null;
            const nomorTelepon = pelangganBaru ? document.getElementById('nomorTelepon').value : null;

            // Menambahkan item ke pesanan
            // tambahKePesanan(barangId, barangName, hargaBarang, jumlahBeli, diskon, pelangganTetap,
            //     namaPelanggan, nomorTelepon);
        });

        function tambahKePesanan(barangId, barangName, hargaBarang, jumlahBeli, diskon, pelangganTetap,
            namaPelanggan, nomorTelepon) {
            const subTotal = (hargaBarang - diskon) * jumlahBeli;

            const existingItem = pesanan.find(item => item.id === barangId);
            if (existingItem) {
                existingItem.jumlah += jumlahBeli;
                existingItem.subTotal += subTotal;
            } else {
                pesanan.push({
                    id: barangId,
                    name: barangName,
                    jumlah: jumlahBeli,
                    harga: hargaBarang,
                    diskon: diskon,
                    Subtotal: subTotal,
                });
            }

            renderPesanan();
        }

        const confirmBeliModalButton = document.getElementById('confirmBeliModalButton');

        confirmBeliModalButton.addEventListener('click', () => {
            if (pesanan.length === 0) {
                alert('Tidak ada pesanan untuk dikonfirmasi.');
                return;
            }

            const form = document.getElementById('formPesanan');
            const inputPesanan = document.getElementById('inputPesanan');
            const inputTotalPembayaran = document.getElementById('inputTotalPembayaran');
            const inputDataPembeli = document.getElementById('inputDataPembeli');

            const isPelangganBiasa = document.getElementById('isPelangganBiasa').checked;
            const isPelangganTetap = document.getElementById('isPelangganTetap').checked;
            const pelangganTetapDropdown = document.getElementById('idPelangganTetap').value;

            const isPelangganBaru = document.getElementById('isPelangganBaru').checked;
            const namaPelanggan = pelangganBaru ? document.getElementById('namaPelanggan').value : null;
            const nomorTelepon = pelangganBaru ? document.getElementById('nomorTelepon').value : null;

            let dataPelanggan = {};


            //masih error di bagian ngirim data pelanggan
            if (isPelangganBiasa) {
                dataPelanggan = {
                    jenis: "Pelanggan Biasa"
                };
            } else if (isPelangganTetap) {
                const pelangganTetapDropdown = document.getElementById('idPelangganTetap').value;
                const pelangganTetap = pelangganTetapDropdown ? pelangganTetapDropdown.value : null;

                if (!pelangganTetap || pelangganTetap === "NULL") {
                    alert('Pilih pelanggan tetap terlebih dahulu.');
                    return;
                }

                dataPelanggan = {
                    jenis: "Pelanggan Tetap",
                    pelangganTetapId: pelangganTetap,
                };
            } else if (isPelangganBaru) {
                const namaPelangganBaru = document.getElementById('namaPelanggan').value.trim();
                const nomorTeleponBaru = document.getElementById('nomorTelepon').value.trim();

                if (!namaPelangganBaru || !nomorTeleponBaru) {
                    alert('Nama dan Nomor Telepon pelanggan baru harus diisi.');
                    return;
                }

                dataPelanggan = {
                    jenis: "Pelanggan Baru",
                    pelangganBaru: {
                        nama: namaPelangganBaru,
                        nomorTelepon: nomorTeleponBaru,
                    },
                };
            } else {
                alert('Pilih salah satu jenis pelanggan.');
                return;
            }

            // Set nilai input hidden untuk data pesanan, total pembayaran, dan data pembeli
            inputPesanan.value = JSON.stringify(pesanan);
            inputTotalPembayaran.value = totalPembayaran;
            inputDataPembeli.value = JSON.stringify(dataPelanggan);

            // Kirim form ke controller
            form.submit();
        });


    });
</script>
