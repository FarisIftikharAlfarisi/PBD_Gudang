<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div id="notaPrintArea">
        <div style="display: flex; justify-content: space-between;">
            <div>
                <h4><strong>No. Nota: {{ $order->Nomor_Nota }}</strong></h4>
                <p><strong>Kasir:</strong> {{ $karyawan->Nama_Karyawan }}</p>
                <p><strong>Metode Pembayaran :</strong> {{ $order->Metode_Pembayaran }}</p>
                
            </div>
            <div style="text-align: right;">
                <h4><strong>Jadi Motor Bandung</strong></h4>
                <p>Jl. Banceuy 125 (Dekat Sate Al Jihad)</p>
                <p>Fax : (022) 123456</p>
                <p>Telepon : (022) 123456</p>
            </div>
        </div>

        <table class="table">
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
                @foreach ($order->order_details as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->relasibarang->Nama_Barang }}</td>
                        <td>{{ $item->Jumlah }}</td>
                        <td>{{ number_format($item->Harga_Jual - $item->Diskon_Per_Items, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->Subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-right">
            <h3><strong>Total: Rp {{ number_format($order->Total_Pembayaran, 0, ',', '.') }}</strong></h3>
        </div>

        @if ($order->Metode_Pembayaran == 'Tunai')
        <div class="text-right">
            <h3><strong>Kembalian: Rp {{ number_format($order->Kembalian, 0, ',', '.') }}</strong></h3>
        </div>
    @endif
    </div>
</body>
</html>
