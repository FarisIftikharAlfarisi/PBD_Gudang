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
                        <!-- Tombol Print untuk mencetak nota -->
                        <button class="btn btn-sm btn-primary" onclick="window.open('{{ route('cetak-nota', $r->id) }}', '_blank')">Print</button>

                        <!-- Tombol View Details untuk melihat detail transaksi -->
                        {{-- <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#transactionModal"
                            data-id="{{ $r->id }}"
                            data-nomor-nota="{{ $r->Nomor_Nota }}"
                            data-tanggal="{{ \Carbon\Carbon::createFromFormat('dmY', $r->Tanggal_Pembelian)->isoFormat('dddd, D MMMM YYYY') }}"
                            data-total-pembayaran="{{ number_format($r->Total_Pembayaran, 0, ',', '.') }}"
                            data-metode-pembayaran="{{ $r->Metode_Pembayaran }}">
                            View Details
                        </button> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Detail Transaksi -->
<div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionModalLabel">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nomor Nota:</strong> <span id="nomor-nota"></span></p>
                <p><strong>Tanggal Transaksi:</strong> <span id="tanggal"></span></p>
                <p><strong>Nilai Transaksi:</strong> Rp. <span id="total-pembayaran"></span></p>
                <p><strong>Metode Pembayaran:</strong> <span id="metode-pembayaran"></span></p>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // JavaScript untuk memuat data ke modal ketika tombol "View Details" diklik
    $('#transactionModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // tombol yang memicu modal
        var id = button.data('id');
        var nomorNota = button.data('nomor-nota');
        var tanggal = button.data('tanggal');
        var totalPembayaran = button.data('total-pembayaran');
        var metodePembayaran = button.data('metode-pembayaran');

        // Isi data ke dalam modal
        var modal = $(this);
        modal.find('#nomor-nota').text(nomorNota);
        modal.find('#tanggal').text(tanggal);
        modal.find('#total-pembayaran').text(totalPembayaran);
        modal.find('#metode-pembayaran').text(metodePembayaran);
    });
</script>
@endsection
@endsection
