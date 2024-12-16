@extends('Partials.dashboard-template-main')

@section('dashboard-content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <!-- Bagian yang akan dicetak -->
                    <div id="notaPrintArea">
                        <div class="row">
                            <!-- Bagian kiri: No. Nota, Nama Pembeli, Nama Kasir -->
                            <div class="col-md-6 mt-3">
                                <h4><strong>No. Nota: {{ $order->Nomor_Nota }}</strong></h4>
                                <p><strong>Kasir:</strong> {{ Auth::guard('karyawan')->user()->Nama_Karyawan }}</p>
                            </div>
                            <!-- Bagian kanan: Nama Perusahaan -->
                            <div class="col-md-6 text-end mt-3">
                                <h4><strong>Jadi Motor Bandung</strong></h4>
                                <p>Jl. Banceuy 125 (Dekat Sate Al Jihad)</p>
                                <p>Fax : (022) 123456</p>
                                <p>Telepon : (022) 123456</p>
                            </div>
                        </div>

                        <table class="table table-bordered mt-4 text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan (Rp)</th>
                                    <th>Subtotal (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderDetail as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->relasibarang->Nama_Barang }}</td>
                                        <td>
                                            {{ $item->Jumlah }}
                                        </td>
                                        <td>
                                            {{ number_format($item->Harga_Jual - $item->Diskon_Per_Items, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            {{ number_format($item->Subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

                        <!-- Total Pembelian -->
                        <div class="text-right mt-4">
                            <h3 id="total-price" data-total-price="{{ $order->Total_Pembayaran }}">
                                <strong id="total-label">Total: Rp
                                    {{ number_format($order->Total_Pembayaran, 0, ',', '.') }}</strong>
                            </h3>
                        </div>

                        {{-- Tampilkan Kembalian --}}
                        <div class="text-right mt-4">
                            <h3 id="change-price">
                                <strong id="total-label">Kembalian: Rp <span id="kembalian-display">0</span>
                                </strong>
                            </h3>
                        </div>

                    </div>

                    <!-- Tombol untuk Print Nota -->
                    <div class="text-center mt-4">
                        <button class="btn btn-primary" onclick="printNota();">Print Nota</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card untuk kembalian dan uang masuk --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Transaksi</div>
                    <form action="" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="Metode_Pembayaran"> Metode Pembayaran </label>
                            <select name="Metode_Pembayaran" id="metodePembayaran" class="form-control">
                                <option value="Null">Pilih Metode Pembayaran</option>
                                <option value="Tunai">Tunai</option>
                                <option value="Transfer">Transfer</option>
                                <option value="QRIS">QRIS</option>
                            </select>
                        </div>
                        <div id="tunaiFields" class="mb-3" style="display: none;">
                            <label for="uang_masuk" class="form-label">Uang Masuk</label>
                            <input type="number" class="form-control" id="uang_masuk" name="uang_masuk" placeholder="Masukkan Uang Masuk">

                            <label for="kembalian" class="form-label mt-3">Kembalian</label>
                            <input type="text" class="form-control" id="kembalian" name="kembalian" readonly>
                        </div>
                        <div id="transferFields" class="mb-3" style="display: none;">
                            <label for="nomor_rekening" class="form-label">Nomor Rekening</label>
                            <p id="nomor_rekening" class="form-control">123-456-789 (Bank ABC)</p>
                        </div>
                        <div id="qrisFields" class="mb-3" style="display: none;">
                            <label for="qris_image" class="form-label">Scan QR Code</label>
                            <img id="qris_image" src="/path/to/qris.png" alt="QR Code" style="width: 200px;">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const totalBayar = {{ $order->Total_Pembayaran }}; // Nilai dari database
            const metodePembayaran = document.getElementById('metodePembayaran');
            const tunaiFields = document.getElementById('tunaiFields');
            const transferFields = document.getElementById('transferFields');
            const qrisFields = document.getElementById('qrisFields');
            const uangMasuk = document.getElementById('uang_masuk');
            const kembalian = document.getElementById('kembalian');
            const kembalianDisplay = document.getElementById('kembalian-display');

            // Fungsi untuk memformat angka dengan pemisah ribuan
            function formatNumber(value) {
                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            // Fungsi untuk menghapus format angka ke nilai asli
            function unformatNumber(value) {
                return value.replace(/\./g, "");
            }

            // Event untuk memformat input uang masuk
            uangMasuk.addEventListener('input', function () {
                const rawValue = unformatNumber(this.value); // Hapus format saat mengetik
                const uangMasukValue = parseInt(rawValue) || 0;

                // Tampilkan format angka di input
                this.value = formatNumber(rawValue);

                // Hitung kembalian
                const hasilKembalian = uangMasukValue - totalBayar;
                const formattedKembalian = hasilKembalian >= 0 ? formatNumber(hasilKembalian) : "0";

                // Update kembalian di input dan elemen change-price
                kembalian.value = formattedKembalian;
                kembalianDisplay.textContent = formattedKembalian;
            });

            // Event untuk menyesuaikan field berdasarkan metode pembayaran
            metodePembayaran.addEventListener('change', function () {
                tunaiFields.style.display = 'none';
                transferFields.style.display = 'none';
                qrisFields.style.display = 'none';

                if (this.value === 'Tunai') {
                    tunaiFields.style.display = 'block';
                } else if (this.value === 'Transfer') {
                    transferFields.style.display = 'block';
                } else if (this.value === 'QRIS') {
                    qrisFields.style.display = 'block';
                }
            });
        });


    </script>


@endsection
