@extends('Partials.dashboard-template-main')

@section('dashboard-content')

<style>
    /* Sembunyikan seluruh halaman saat print kecuali div yang diinginkan */
@media print {
    body * {
        visibility: hidden;
    }
    #notaPrintArea, #notaPrintArea * {
        visibility: visible;
    }
    #notaPrintArea {
        position: absolute;
        left: 0;
        top: 0;
    }
}

</style>

<div class="card">
    <div class="card-body">
         <!-- Bagian yang akan dicetak -->
         <div id="notaPrintArea">
        <div class="row">
            <!-- Bagian kiri: No. Nota, Nama Pembeli, Nama Kasir -->
            <div class="col-md-6 mt-3">
                <h4><strong>No. Nota:</strong> 123456</h4>
                <p><strong>Pembeli:</strong> {{ $pembeli->nama }}</p>
                <p><strong>Kasir:</strong> {{ $kasir->nama }}</p>
            </div>
            <!-- Bagian kanan: Nama Perusahaan -->
            <div class="col-md-6 text-end mt-3">
                <h4><strong>Jadi Motor Bandung</strong></h4>
                <p>Jl. Banceuy 125 (Dekat Sate Al Jihad)</p>
                <p>Fax : (022) 123456</p>
                <p>Telepon : (022) 123456</p>
            </div>
        </div>

        <!-- Tabel Barang yang Dibeli -->
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan (Rp)</th>
                    <th>Total Harga (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangDetails as $index => $barang)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->pivot->jumlah }}</td>
                    <td>{{ number_format($barang->harga, 0, ',', '.') }}</td>
                    <td>{{ number_format($barang->pivot->jumlah * $barang->harga, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total Pembelian -->
        <div class="text-right mt-4">
            <h3><strong>Total: Rp {{ number_format($total, 0, ',', '.') }}</strong></h3>
        </div>
         </div>

        <!-- Tombol untuk Print Nota -->
        <div class="text-center mt-4">
            <button class="btn btn-primary" onclick="printNota();">Print Nota</button>
        </div>
    </div>
</div>

<script>
    function printNota() {
        window.print();
    }
</script>

@endsection
