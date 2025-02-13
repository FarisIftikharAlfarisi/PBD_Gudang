@extends('Partials.dashboard-template-main')

@section('dashboard-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                </div>
            </div>
        </div>

        {{-- Card untuk kembalian dan uang masuk --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Transaksi</div>
                    <form>
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
                            <input type="number" class="form-control" id="uang_masuk" name="uang_masuk"
                                placeholder="Masukkan Uang Masuk">
                    
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
                    </form>
                    <form id="fallbackForm" action="{{ route('update-pesanan', $order->Nomor_Nota) }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT"> <!-- Alternatif untuk @method('PUT') -->
                        <input type="hidden" id="nomor_nota_form" name="nomor_nota" value="{{ $order->Nomor_Nota }}">
                        <input type="hidden" id="metode_pembayaran_form" name="metode_pembayaran">
                        <input type="hidden" id="uang_masuk_form" name="uang_masuk">
                        <input type="hidden" id="kembalian_form" name="kembalian">
                        {{-- <button type="submit" id="btnBayar" class="btn btn-primary">Bayar</button> --}}
                    </form>
                    <button type="submit" id="btnBayar" class="btn btn-primary">Bayar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const totalBayar = {{ $order->Total_Pembayaran }}; // Nilai dari database
            const metodePembayaran = document.getElementById('metodePembayaran');
            const tunaiFields = document.getElementById('tunaiFields');
            const transferFields = document.getElementById('transferFields');
            const qrisFields = document.getElementById('qrisFields');
            const uangMasuk = document.getElementById('uang_masuk');
            const kembalian = document.getElementById('kembalian');
            const kembalianDisplay = document.getElementById('kembalian-display');
    
            // Fungsi untuk membersihkan format angka
            function unformatNumber(value) {
                return value.replace(/\./g, ''); // Hapus semua titik (pemisah ribuan)
            }

            // Fungsi untuk memformat angka dengan pemisah ribuan
            function formatNumber(value) {
                return new Intl.NumberFormat('id-ID').format(value);
            }

            // Event listener untuk input uang masuk
            uangMasuk.addEventListener('input', function() {
                const rawValue = unformatNumber(this.value); // Bersihkan format angka
                if (rawValue === "") {
                    this.value = ""; // Kosongkan field jika input kosong
                    kembalian.value = "0"; // Reset kembalian ke 0
                    kembalianDisplay.textContent = "0";
                    return;
                }

                const uangMasukValue = parseInt(rawValue, 10) || 0; // Parse angka dengan basis 10
                if (isNaN(uangMasukValue) || uangMasukValue < 0) {
                    alert("Input tidak valid. Masukkan angka positif.");
                    this.value = "";
                    kembalian.value = "0";
                    kembalianDisplay.textContent = "0";
                    return;
                }

                this.value = formatNumber(rawValue); // Format ulang angka untuk ditampilkan

                const hasilKembalian = uangMasukValue - totalBayar; // Hitung kembalian
                const formattedKembalian = hasilKembalian >= 0 ? formatNumber(hasilKembalian.toString()) : "0";

                kembalian.value = formattedKembalian; // Update field kembalian
                kembalianDisplay.textContent = formattedKembalian; // Update tampilan kembalian
            });

            // Event untuk menyesuaikan field berdasarkan metode pembayaran
            metodePembayaran.addEventListener('change', function() {
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
    
            // Fungsi untuk fallback form submission dan buka tab baru untuk cetak nota
            async function fallbackFormSubmission() {
                const orderId = {{ $order->id }}; // Ganti dengan ID dari order
                const metode = metodePembayaran.value;
                
                let uangMasukValue = 0;
                let kembalianValue = 0;
    
                if (metode === "Tunai") {
                    uangMasukValue = parseInt(unformatNumber(uangMasuk.value)) || 0;
                    kembalianValue = parseInt(unformatNumber(kembalian.value)) || 0;
    
                    if (kembalianValue < 0) {
                        alert("Uang masuk tidak cukup untuk membayar total pesanan.");
                        return;
                    }
                } else if (metode === "Transfer" || metode === "QRIS") {
                    uangMasukValue = totalBayar;
                    kembalianValue = 0;
                } else {
                    alert("Pilih metode pembayaran terlebih dahulu.");
                    return;
                }
                document.getElementById("nomor_nota_form").value = orderId; // Ganti nomor_nota_form dengan ID
                document.getElementById("metode_pembayaran_form").value = metode;
                document.getElementById("uang_masuk_form").value = uangMasukValue;
                document.getElementById("kembalian_form").value = kembalianValue;
    
                // Submit form fallback dan tunggu hingga selesai
                const form = document.getElementById("fallbackForm");
                const formData = new FormData(form);
                
                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    
                    if (response.ok) {
                        // Setelah form berhasil disubmit, buka tab baru untuk cetak nota
                        const printUrl = "{{ route('cetak-nota', ':id') }}".replace(':id', orderId);
                        window.open(printUrl, '_blank');
                        
                        // Tambahkan refresh otomatis setelah 2 detik
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    } else {
                        alert('Terjadi kesalahan saat menyimpan data pembayaran.');
                    }
                } catch (error) {
                    alert('Terjadi kesalahan saat menyimpan data pembayaran.');
                    console.error('Error:', error);
                }
            }
    
            // Event Listener untuk tombol bayar
            document.getElementById('btnBayar').addEventListener('click', fallbackFormSubmission);
            // Isi nilai pada form fallback
            
        });
    </script>    
@endsection
