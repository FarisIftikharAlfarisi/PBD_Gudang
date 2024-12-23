@extends('Partials.dashboard-template-main')

@section('dashboard-content')
<div class="pagetitle">
    <h1>Riwayat Pembelian</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('kasir-index-page') }}">Kasir</a></li>
            <li class="breadcrumb-item active">Riwayat Pembelian</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <div class="card-title">Riwayat Transaksi dari {{ Auth::guard('karyawan')->user()->Kode_Karyawan }}</div>
        <table class="table datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nomor Nota</th>
                    <th>Tanggal Transaksi</th>
                    <th>Nilai Transaksi</th>
                    <th>Metode Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayat as $r)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $r->Nomor_Nota }}</td>
                    <td>{{ \Carbon\Carbon::createFromFormat('dmY', $r->Tanggal_Pembelian)->isoFormat('dddd, D MMMM YYYY') }}</td>
                    <td>Rp. {{ number_format($r->Total_Pembayaran, 0, ',', '.') }}</td>
                    <td>{{ $r->Metode_Pembayaran }}</td>
                    <td>
                        <!-- Tombol untuk membuka modal detail -->
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalDetail" 
                                onclick="loadDetail('{{ $r->id }}')">Detail</button>
                        <button class="btn btn-sm btn-primary" onclick="window.open('{{ route('cetak-nota', $r->id) }}', '_blank')">Print</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="detailContent">Memuat detail...</div>
            </div>
        </div>
    </div>
</div>

<script>
    function loadDetail(id) {
        const detailContent = document.getElementById('detailContent');
        detailContent.innerHTML = 'Memuat detail...';
    
        fetch(`/transaksi/detail/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let html = `
                        <p><strong>Nomor Nota:</strong> ${data.detail.Nomor_Nota}</p>
                        <p><strong>Tanggal Transaksi:</strong> ${data.detail.Tanggal_Pembelian}</p>
                        <p><strong>Metode Pembayaran:</strong> ${data.detail.Metode_Pembayaran}</p>
                        <h5>Detail Barang:</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Diskon Per Barang</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>`;
                    data.detail.items.forEach((item, index) => {
                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.nama_barang}</td>
                                <td>${item.jumlah}</td>
                                <td>Rp. ${item.harga}</td>
                                <td>Rp. ${item.diskon}</td>
                                <td>Rp. ${item.subtotal}</td>
                            </tr>`;
                    });
                    html += `</tbody></table>`;
    
                    // Now add the payment details below the table
                    html += `
                        <div>
                            <p><strong>Total Pembayaran:</strong> Rp. ${data.detail.Total_Pembayaran}</p>
                            <p><strong>Cash:</strong> Rp. ${data.detail.Uang_Masuk}</p>
                            <p><strong>Kembalian:</strong> Rp. ${data.detail.Kembalian}</p>
                        </div>`;
    
                    detailContent.innerHTML = html;
                } else {
                    detailContent.innerHTML = 'Gagal memuat detail.';
                }
            })
            .catch(() => {
                detailContent.innerHTML = 'Terjadi kesalahan saat memuat detail.';
            });
    }
    </script>
    

@endsection
